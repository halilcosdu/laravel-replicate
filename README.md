# Laravel Replicate

[![Latest Version on Packagist](https://img.shields.io/packagist/v/halilcosdu/laravel-replicate.svg?style=flat-square)](https://packagist.org/packages/halilcosdu/laravel-replicate)
[![PHP Version](https://img.shields.io/packagist/dependency-v/halilcosdu/laravel-replicate/php?style=flat-square)](https://packagist.org/packages/halilcosdu/laravel-replicate)
[![License](https://img.shields.io/packagist/l/halilcosdu/laravel-replicate?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/halilcosdu/laravel-replicate.svg?style=flat-square)](https://packagist.org/packages/halilcosdu/laravel-replicate)

A Laravel-native client for the [Replicate HTTP API](https://replicate.com/docs/reference/http). Run community, official, and deployment models; manage models and trainings; upload files; and authenticate incoming webhooks using Laravel's familiar HTTP client and facade APIs.

## Highlights

- Laravel 11, 12, and 13 support, including PHP 8.5 on supported framework versions.
- Predictions for community models, official models, and deployments.
- Sync mode, prediction deadlines, filters, and cursor pagination.
- Multipart uploads and resource management through Replicate's Files API.
- HMAC-SHA256 webhook verification with timestamp and key-rotation support.
- Native `Illuminate\Http\Client\Response` results with accurate IDE return types.
- Hermetic HTTP tests, PHPStan analysis, and a full version matrix in CI.

## Requirements

| Laravel | Supported PHP versions | Framework status in 2026 |
| --- | --- | --- |
| 11.x | 8.2–8.4 | Legacy compatibility; EOL |
| 12.x | 8.2–8.5 | Security-supported |
| 13.x | 8.3–8.5 | Actively supported |

The matrix follows Laravel's [official support policy](https://laravel.com/docs/13.x/releases#support-policy). The package requires PHP `^8.2`; PHP 8.5 is tested with Laravel 12 and 13. Laravel 11 is not paired with PHP 8.5 because that combination is not supported by the framework itself.

Laravel 11 reached end-of-life on March 12, 2026 and currently has upstream security advisories. Compatibility remains available for migration windows because it is an explicit target of this package, but new and internet-facing applications should use Laravel 12 or 13. Composer may report or block affected Laravel 11 dependency resolutions; do not suppress that warning in production without reviewing the advisories.

## Installation

Install the package with Composer:

```bash
composer require halilcosdu/laravel-replicate
```

Laravel discovers the service provider and facade automatically. Publish the configuration only when you need to customize it:

```bash
php artisan vendor:publish --tag=replicate-config
```

Add your Replicate API token to `.env`:

```dotenv
REPLICATE_API_TOKEN=r8_your_token
```

The published configuration contains:

```php
return [
    'api_token' => env('REPLICATE_API_TOKEN'),
    'api_url' => env('REPLICATE_API_URL', 'https://api.replicate.com/v1'),
    'webhook_secret' => env('REPLICATE_WEBHOOK_SECRET'),
    'webhook_tolerance' => (int) env('REPLICATE_WEBHOOK_TOLERANCE', 300),
];
```

## Quick start

All API methods return Laravel's HTTP client `Response`, so `throw()`, `json()`, `collect()`, `successful()`, and the other standard response helpers are available.

```php
use HalilCosdu\Replicate\Facades\Replicate;

$prediction = Replicate::createOfficialModelPrediction(
    owner: 'black-forest-labs',
    name: 'flux-schnell',
    data: [
        'input' => ['prompt' => 'A quiet library floating above Istanbul'],
    ],
)->throw()->json();

$predictionId = $prediction['id'];
```

Run a versioned community model through the generic predictions endpoint:

```php
$response = Replicate::createPrediction([
    'version' => 'replicate/hello-world:version-id',
    'input' => ['text' => 'Laravel'],
]);

$prediction = $response->throw()->json();
```

### Sync mode and deadlines

Prediction creation methods accept optional request headers. `Prefer` controls how long the HTTP request waits; `Cancel-After` controls the prediction's lifetime.

```php
$response = Replicate::createOfficialModelPrediction(
    'black-forest-labs',
    'flux-schnell',
    ['input' => ['prompt' => 'Minimal geometric poster']],
    ['Prefer' => 'wait=30', 'Cancel-After' => '2m'],
);

$prediction = $response->throw()->json();
```

A sync request may still return `starting` or `processing` when the wait period expires. Retrieve its latest state with:

```php
$prediction = Replicate::getPrediction($predictionId)->throw()->json();
```

### Pagination and filters

List methods accept an optional query array and pass it directly to Replicate:

```php
$page = Replicate::listPredictions([
    'created_after' => now()->subDay()->toIso8601String(),
    'source' => 'web',
    'cursor' => $cursor,
])->throw()->json();
```

This is supported by `listCollections`, `listDeployments`, `listFiles`, `listModels`, `listModelExamples`, `listPredictions`, and `listTrainings`.

## Files API

Upload a string or readable PHP stream as multipart content. Metadata is encoded as a JSON multipart field.

```php
$stream = fopen(storage_path('app/training-images.zip'), 'rb');

throw_if($stream === false, RuntimeException::class, 'Unable to open the upload.');

try {
    $file = Replicate::createFile(
        contents: $stream,
        filename: 'training-images.zip',
        contentType: 'application/zip',
        metadata: ['dataset' => 'product-photography'],
    )->throw()->json();
} finally {
    fclose($stream);
}
```

Manage uploaded resources with `listFiles()`, `getFile($id)`, `deleteFile($id)`, and `downloadFile($id, $owner, $expiry, $signature)`.

## Webhook verification

Never trust a webhook payload before verifying its signature. First retrieve your signing secret once, then store it securely rather than requesting it for every delivery:

```php
$secret = Replicate::defaultSecret()->throw()->json('key');
```

```dotenv
REPLICATE_WEBHOOK_SECRET=whsec_your_signing_secret
```

Verify the untouched Laravel request before processing its JSON body:

```php
use HalilCosdu\Replicate\Facades\Replicate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/replicate', function (Request $request) {
    abort_unless(Replicate::verifyWebhook($request), 401);

    $prediction = $request->json()->all();

    // Persist output, dispatch a job, or continue a model pipeline...

    return response()->noContent();
});
```

`verifyWebhook()` validates the `webhook-id`, `webhook-timestamp`, and every `v1` candidate in `webhook-signature` using constant-time comparison. Requests outside the configured 300-second tolerance are rejected to reduce replay risk. You may override the secret and tolerance for a specific request:

```php
$valid = Replicate::verifyWebhook($request, $secret, tolerance: 120);
```

Remember to exempt the webhook route from CSRF protection and make processing idempotent because Replicate may retry a delivery.

## API reference

### Account, discovery, and hardware

```php
Replicate::account();
Replicate::search(string $query, ?int $limit = null);
Replicate::listHardware();
```

### Collections

```php
Replicate::listCollections(array $query = []);
Replicate::getCollection(string $slug);
```

### Deployments

```php
Replicate::listDeployments(array $query = []);
Replicate::createDeployment(array $data);
Replicate::getDeployment(string $owner, string $name);
Replicate::updateDeployment(string $owner, string $name, array $data);
Replicate::deleteDeployment(string $owner, string $name);
Replicate::createDeploymentPrediction(string $owner, string $name, array $data, array $headers = []);
```

### Files

```php
Replicate::createFile(mixed $contents, string $filename, string $contentType = 'application/octet-stream', array $metadata = []);
Replicate::listFiles(array $query = []);
Replicate::getFile(string $id);
Replicate::deleteFile(string $id);
Replicate::downloadFile(string $id, string $owner, int $expiry, string $signature);
```

### Models and versions

```php
Replicate::listModels(array $query = []);
Replicate::createModel(array $data);
Replicate::getModel(string $owner, string $name);
Replicate::updateModel(string $owner, string $name, array $data);
Replicate::deleteModel(string $owner, string $name);
Replicate::getModelReadme(string $owner, string $name);
Replicate::searchModels(string $query);
Replicate::listModelExamples(string $owner, string $name, array $query = []);
Replicate::listModelVersions(string $owner, string $name);
Replicate::getModelVersion(string $owner, string $name, string $version);
Replicate::deleteModelVersion(string $owner, string $name, string $version);
```

### Predictions

```php
Replicate::createPrediction(array $data, array $headers = []);
Replicate::createOfficialModelPrediction(string $owner, string $name, array $data, array $headers = []);
Replicate::getPrediction(string $id);
Replicate::listPredictions(array $query = []);
Replicate::cancelPrediction(string $id);
```

The legacy `createModelPrediction($owner, $name, $version, $data, $headers)` method remains available for backward compatibility. Replicate's official-model endpoint does not accept a version path parameter, so new code should use `createOfficialModelPrediction()`.

### Trainings

```php
Replicate::listTrainings(array $query = []);
Replicate::createTraining(string $owner, string $name, string $version, array $data);
Replicate::getTraining(string $id);
Replicate::cancelTraining(string $id);
```

### Webhooks

```php
Replicate::defaultSecret();
Replicate::verifyWebhook(Request $request, ?string $secret = null, ?int $tolerance = null);
```

## Error handling

The client does not hide API failures. Use Laravel's standard response helpers according to your application's needs:

```php
$response = Replicate::getPrediction($predictionId);

if ($response->tooManyRequests()) {
    // Release the job using Retry-After or your own backoff policy.
}

$prediction = $response->throw()->json();
```

See Laravel's [HTTP client documentation](https://laravel.com/docs/http-client) for response inspection, retries, exceptions, and test fakes.

## Testing and quality

```bash
composer test
composer analyse
vendor/bin/pint --test
```

The GitHub Actions matrix covers supported Laravel 11–13 and PHP 8.2–8.5 combinations with both lowest and stable dependency sets.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for release notes.

## Security

Please follow [SECURITY.md](SECURITY.md) to report vulnerabilities privately.

## Credits

- [Halil Cosdu](https://github.com/halilcosdu)
- [All contributors](https://github.com/halilcosdu/laravel-replicate/graphs/contributors)

## License

Laravel Replicate is open-source software licensed under the [MIT license](LICENSE.md).
