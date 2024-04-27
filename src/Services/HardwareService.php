<?php

namespace HalilCosdu\Replicate\Services;

use Illuminate\Support\Facades\Http;

class HardwareService
{
    /*
     * https://replicate.com/docs/reference/http#hardware.list
     */
    public function list()
    {
        return Http::replicate()->get('/hardware');
    }
}
