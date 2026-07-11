<?php

namespace HalilCosdu\Replicate\Services;

use HalilCosdu\Replicate\Facades\Http;
use Illuminate\Http\Client\Response;

class AuthService
{
    /*
     * https://replicate.com/docs/reference/http#account.get
     */
    public function account(): Response
    {
        return Http::replicate()->get('/account');
    }
}
