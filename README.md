# Replicate Laravel client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/halilcosdu/laravel-replicate.svg?style=flat-square)](https://packagist.org/packages/halilcosdu/laravel-replicate)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/halilcosdu/laravel-replicate/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/halilcosdu/laravel-replicate/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/halilcosdu/laravel-replicate/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/halilcosdu/laravel-replicate/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/halilcosdu/laravel-replicate.svg?style=flat-square)](https://packagist.org/packages/halilcosdu/laravel-replicate)

The halilcosdu/laravel-replicate package is a Laravel client for the Replicate API. It provides a convenient way to interact with the Replicate API using PHP and Laravel's Facade pattern.  The package includes methods for managing and interacting with various aspects of the Replicate service, such as accounts, collections, deployments, hardware, models, predictions, and trainings.  For example, you can list all collections, get a specific collection, create a new deployment, get or update an existing deployment, list all hardware, create a new model, get a specific model or its version, list all versions of a model, delete a model version, list all models, create a prediction, get or cancel a prediction, list all predictions, list all trainings, create a new training, get or cancel a training, get the default secret, and create a deployment or model prediction.  The package is configurable via Laravel's configuration system, allowing you to set your API token and URL through your environment file.
## Installation

You can install the package via composer:

```bash
composer require halilcosdu/laravel-replicate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="replicate-config"
```

This is the contents of the published config file:

```php
return [
    'api_token' => env('REPLICATE_API_TOKEN'),
    'api_url' => env('REPLICATE_API_URL', 'https://api.replicate.com/v1'),
];
```

## Usage
```php
Replicate::account()
Replicate::getCollection(string $slug)
Replicate::listCollections()
Replicate::listDeployments()
Replicate::createDeployment(array $data)
Replicate::getDeployment(string $owner, string $name)
Replicate::updateDeployment(string $owner, string $name, array $data)
Replicate::listHardware()
Replicate::createModel(array $data)
Replicate::getModel(string $owner, string $name)
Replicate::getModelVersion(string $owner, string $name, string $version)
Replicate::listModelVersions(string $owner, string $name)
Replicate::deleteModelVersion(string $owner, string $name, string $version)
Replicate::listModels()
Replicate::createPrediction(array $data)
Replicate::getPrediction(string $id)
Replicate::cancelPrediction($id)
Replicate::listPredictions()
Replicate::listTrainings()
Replicate::createTraining(string $owner, string $name, string $version, array $data)
Replicate::getTraining(string $id)
Replicate::cancelTraining($id)
Replicate::defaultSecret()
Replicate::createDeploymentPrediction(string $owner, string $name, array $data)
Replicate::createModelPrediction(string $owner, string $name, string $version, array $data)
```
#### Reference: https://replicate.com/docs/reference/http
## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Halil Cosdu](https://github.com/halilcosdu)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
