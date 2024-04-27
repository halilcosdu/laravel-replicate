<?php

namespace HalilCosdu\Replicate\Services;

use Illuminate\Support\Facades\Http;

class CollectionService
{
    /*
     * https://replicate.com/docs/reference/http#collections.get
     */
    public function get(string $slug)
    {
        return Http::replicate()->get("/collections/$slug");
    }

    /*
     * https://replicate.com/docs/reference/http#collections.list
     */
    public function list()
    {
        return Http::replicate()->get('/collections');
    }
}
