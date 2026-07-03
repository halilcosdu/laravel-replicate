<?php

namespace HalilCosdu\Replicate\Services;

use Illuminate\Support\Facades\Http;

class PredictionService
{
    /*
    * https://replicate.com/docs/reference/http#predictions.create
    * Pass headers like ['Prefer' => 'wait=60', 'Cancel-After' => '5m'].
    */
    public function create(array $data, array $headers = [])
    {
        return Http::replicate()->withHeaders($headers)->post('/predictions', $data);
    }

    /*
     * https://replicate.com/docs/reference/http#predictions.get
     */
    public function get(string $id)
    {
        return Http::replicate()->get("/predictions/$id");
    }

    /*
     * https://replicate.com/docs/reference/http#predictions.list
     */
    public function list(array $query = [])
    {
        return Http::replicate()->get('/predictions', $query);
    }

    /*
     * https://replicate.com/docs/reference/http#predictions.cancel
     */
    public function cancel($id)
    {
        return Http::replicate()->post("/predictions/$id/cancel");
    }

    /*
     * https://replicate.com/docs/reference/http#deployments.predictions.create
     * Pass headers like ['Prefer' => 'wait=60', 'Cancel-After' => '5m'].
     */
    public function createDeploymentPrediction(string $owner, string $name, array $data, array $headers = [])
    {
        return Http::replicate()->withHeaders($headers)->post("/deployments/$owner/$name/predictions", $data);
    }

    /*
     * https://replicate.com/docs/reference/http#models.predictions.create
     * Pass headers like ['Prefer' => 'wait=60', 'Cancel-After' => '5m'].
     */
    public function createModelPrediction(string $owner, string $name, string $version, array $data, array $headers = [])
    {
        return Http::replicate()->withHeaders($headers)->post("/models/$owner/$name/predictions", $data);
    }
}
