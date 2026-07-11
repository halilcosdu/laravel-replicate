<?php

namespace HalilCosdu\Replicate;

use Illuminate\Http\Request;
use InvalidArgumentException;

final class WebhookVerifier
{
    private const SIGNATURE_VERSION = 'v1';

    public function verify(Request $request, string $secret, int $tolerance = 300): bool
    {
        $id = $request->header('webhook-id');
        $timestamp = $request->header('webhook-timestamp');
        $signatures = $request->header('webhook-signature');

        if (! is_string($id) || ! is_string($timestamp) || ! is_string($signatures)) {
            return false;
        }

        return $this->verifyPayload(
            payload: $request->getContent(),
            id: $id,
            timestamp: $timestamp,
            signatures: $signatures,
            secret: $secret,
            tolerance: $tolerance,
        );
    }

    public function verifyPayload(
        string $payload,
        string $id,
        string $timestamp,
        string $signatures,
        string $secret,
        int $tolerance = 300,
    ): bool {
        if ($tolerance < 0) {
            throw new InvalidArgumentException('Webhook tolerance must be zero or greater.');
        }

        $timestampValue = filter_var(
            $timestamp,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 0]],
        );

        if ($timestampValue === false || abs(time() - $timestampValue) > $tolerance) {
            return false;
        }

        $key = $this->decodeSecret($secret);

        if ($key === null) {
            return false;
        }

        $signedContent = "$id.$timestamp.$payload";
        $expected = base64_encode(hash_hmac('sha256', $signedContent, $key, true));
        $candidates = preg_split('/\s+/', trim($signatures)) ?: [];

        foreach ($candidates as $candidate) {
            [$version, $signature] = array_pad(explode(',', $candidate, 2), 2, null);

            if ($version === self::SIGNATURE_VERSION
                && is_string($signature)
                && hash_equals($expected, $signature)) {
                return true;
            }
        }

        return false;
    }

    private function decodeSecret(string $secret): ?string
    {
        if (! str_starts_with($secret, 'whsec_')) {
            return null;
        }

        $key = base64_decode(substr($secret, 6), true);

        return is_string($key) && $key !== '' ? $key : null;
    }
}
