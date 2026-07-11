<?php

namespace HalilCosdu\Replicate\Services;

use HalilCosdu\Replicate\Facades\Http;
use Illuminate\Http\Client\Response;

class WebhookService
{
    /*
     * https://replicate.com/docs/reference/http#webhooks.default.secret.get
     */
    public function defaultSecret(): Response
    {
        return Http::replicate()->get('/webhooks/default/secret');
    }
}
