<?php

use HalilCosdu\Replicate\Facades\Replicate;
use HalilCosdu\Replicate\WebhookVerifier;
use Illuminate\Http\Request;

function replicateWebhookSecret(): string
{
    return 'whsec_'.base64_encode('replicate-test-signing-key');
}

function replicateWebhookRequest(
    string $payload,
    string $secret,
    ?int $timestamp = null,
    string $id = 'msg_test_123',
): Request {
    $timestamp = (string) ($timestamp ?? time());
    $key = base64_decode(substr($secret, 6), true);
    $signature = base64_encode(hash_hmac('sha256', "$id.$timestamp.$payload", $key, true));
    $request = Request::create('/webhooks/replicate', 'POST', content: $payload);
    $request->headers->set('webhook-id', $id);
    $request->headers->set('webhook-timestamp', $timestamp);
    $request->headers->set('webhook-signature', "v1,$signature");

    return $request;
}

describe('Replicate webhook verification', function () {
    beforeEach(function () {
        config([
            'replicate.webhook_secret' => replicateWebhookSecret(),
            'replicate.webhook_tolerance' => 300,
        ]);
    });

    it('accepts an authentic request using the configured secret', function () {
        $request = replicateWebhookRequest('{"id":"prediction-1"}', replicateWebhookSecret());

        expect(Replicate::verifyWebhook($request))->toBeTrue();
    });

    it('accepts any matching v1 signature during key rotation', function () {
        $request = replicateWebhookRequest('{"status":"succeeded"}', replicateWebhookSecret());
        $validSignature = $request->header('webhook-signature');
        $request->headers->set('webhook-signature', "v1,invalid $validSignature v2,ignored");

        expect(Replicate::verifyWebhook($request))->toBeTrue();
    });

    it('accepts an explicitly supplied secret and tolerance', function () {
        config(['replicate.webhook_secret' => null]);
        $request = replicateWebhookRequest('{"status":"processing"}', replicateWebhookSecret());

        expect(Replicate::verifyWebhook($request, replicateWebhookSecret(), 60))->toBeTrue();
    });

    it('rejects a modified payload', function () {
        $request = replicateWebhookRequest('{"status":"succeeded"}', replicateWebhookSecret());
        $tampered = Request::create('/webhooks/replicate', 'POST', content: '{"status":"failed"}');
        $tampered->headers->replace($request->headers->all());

        expect(Replicate::verifyWebhook($tampered))->toBeFalse();
    });

    it('rejects stale requests to prevent replay attacks', function () {
        $request = replicateWebhookRequest('{"status":"succeeded"}', replicateWebhookSecret(), time() - 301);

        expect(Replicate::verifyWebhook($request))->toBeFalse();
    });

    it('rejects requests with missing signature headers', function () {
        $request = Request::create('/webhooks/replicate', 'POST', content: '{}');

        expect(Replicate::verifyWebhook($request))->toBeFalse();
    });

    it('fails clearly when no signing secret is configured', function () {
        config(['replicate.webhook_secret' => null]);

        Replicate::verifyWebhook(Request::create('/webhooks/replicate', 'POST', content: '{}'));
    })->throws(LogicException::class, 'A Replicate webhook secret is required');

    it('rejects invalid secrets without leaking signature details', function () {
        $request = replicateWebhookRequest('{}', replicateWebhookSecret());

        expect(app(WebhookVerifier::class)->verify($request, 'not-a-replicate-secret'))->toBeFalse();
    });

    it('rejects a negative replay tolerance', function () {
        $request = replicateWebhookRequest('{}', replicateWebhookSecret());

        app(WebhookVerifier::class)->verify($request, replicateWebhookSecret(), -1);
    })->throws(InvalidArgumentException::class, 'Webhook tolerance must be zero or greater');
});
