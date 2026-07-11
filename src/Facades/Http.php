<?php

namespace HalilCosdu\Replicate\Facades;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http as BaseHttp;

/**
 * @method static PendingRequest replicate()
 */
class Http extends BaseHttp
{
    // Typed facade for the package's Http::replicate() macro.
}
