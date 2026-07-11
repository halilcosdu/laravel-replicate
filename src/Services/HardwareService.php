<?php

namespace HalilCosdu\Replicate\Services;

use HalilCosdu\Replicate\Facades\Http;
use Illuminate\Http\Client\Response;

class HardwareService
{
    /*
     * https://replicate.com/docs/reference/http#hardware.list
     */
    public function list(): Response
    {
        return Http::replicate()->get('/hardware');
    }
}
