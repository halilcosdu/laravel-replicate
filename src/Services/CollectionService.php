<?php

namespace HalilCosdu\Replicate\Services;

use HalilCosdu\Replicate\Facades\Http;
use Illuminate\Http\Client\Response;

class CollectionService
{
    /*
     * https://replicate.com/docs/reference/http#collections.get
     */
    public function get(string $slug): Response
    {
        return Http::replicate()->get("/collections/$slug");
    }

    /*
     * https://replicate.com/docs/reference/http#collections.list
     */
    public function list(array $query = []): Response
    {
        return Http::replicate()->get('/collections', $query);
    }
}
