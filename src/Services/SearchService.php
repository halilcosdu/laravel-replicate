<?php

namespace HalilCosdu\Replicate\Services;

use Illuminate\Support\Facades\Http;

class SearchService
{
    /*
     * https://replicate.com/docs/reference/http#search
     * Beta: search public models, collections, and docs.
     */
    public function search(string $query, ?int $limit = null)
    {
        $parameters = array_filter(['query' => $query, 'limit' => $limit]);

        return Http::replicate()->get('/search', $parameters);
    }
}
