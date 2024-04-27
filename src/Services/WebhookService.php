<?php

namespace HalilCosdu\Replicate\Services;

use Illuminate\Support\Facades\Http;

class WebhookService
{
    /*
     * https://replicate.com/docs/reference/http#webhooks.default.secret.get
     */
    public function defaultSecret()
    {
        return Http::replicate()->get('/webhooks/default/secret');
    }
}
