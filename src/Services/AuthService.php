<?php

namespace HalilCosdu\Replicate\Services;

use Illuminate\Support\Facades\Http;

class AuthService
{
    /*
     * https://replicate.com/docs/reference/http#account.get
     */
    public function account()
    {
        return Http::replicate()->get('/account');
    }
}
