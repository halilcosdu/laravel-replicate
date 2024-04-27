<?php

namespace HalilCosdu\Replicate\Services;

use Illuminate\Support\Facades\Http;

class TrainingService
{
    /*
     * https://replicate.com/docs/reference/http#trainings.create
     */
    public function create(string $owner, string $name, string $version, array $data)
    {
        return Http::replicate()->post("/models/$owner/$name/versions/$version/trainings", $data);
    }

    /*
     * https://replicate.com/docs/reference/http#trainings.get
     */
    public function get(string $id)
    {
        return Http::replicate()->get("/trainings/$id");
    }

    /*
     * https://replicate.com/docs/reference/http#trainings.list
     */
    public function list()
    {
        return Http::replicate()->get('/trainings');
    }

    /*
     * https://replicate.com/docs/reference/http#trainings.cancel
     */
    public function cancel($id)
    {
        return Http::replicate()->post("/trainings/$id/cancel");
    }
}
