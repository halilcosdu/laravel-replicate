<?php

namespace HalilCosdu\Replicate\Services;

use Illuminate\Support\Facades\Http;

class PredictionService
{
    /*
    * https://replicate.com/docs/reference/http#predictions.create
    */
    public function create(array $data)
    {
        return Http::replicate()->post('/predictions', $data);
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
    public function list()
    {
        return Http::replicate()->get('/predictions');
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
     */
    public function createDeploymentPrediction(string $owner, string $name, array $data)
    {
        return Http::replicate()->post("/deployments/$owner/$name/predictions", $data);
    }

    /*
     * https://replicate.com/docs/reference/http#models.predictions.create
     */
    public function createModelPrediction(string $owner, string $name, string $version, array $data)
    {
        return Http::replicate()->post("/models/$owner/$name/predictions", $data);
    }
}
