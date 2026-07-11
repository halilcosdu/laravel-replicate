<?php

namespace HalilCosdu\Replicate\Services;

use HalilCosdu\Replicate\Facades\Http;
use Illuminate\Http\Client\Response;

class SearchService
{
    /*
     * https://replicate.com/docs/reference/http#search
     * Beta: search public models, collections, and docs.
     */
    public function search(string $query, ?int $limit = null): Response
    {
        $parameters = array_filter(['query' => $query, 'limit' => $limit]);

        return Http::replicate()->get('/search', $parameters);
    }
}
