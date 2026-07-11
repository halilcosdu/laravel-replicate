<?php

namespace HalilCosdu\Replicate\Services;

use HalilCosdu\Replicate\Facades\Http;
use Illuminate\Http\Client\Response;

class TrainingService
{
    /*
     * https://replicate.com/docs/reference/http#trainings.create
     */
    public function create(string $owner, string $name, string $version, array $data): Response
    {
        return Http::replicate()->post("/models/$owner/$name/versions/$version/trainings", $data);
    }

    /*
     * https://replicate.com/docs/reference/http#trainings.get
     */
    public function get(string $id): Response
    {
        return Http::replicate()->get("/trainings/$id");
    }

    /*
     * https://replicate.com/docs/reference/http#trainings.list
     */
    public function list(array $query = []): Response
    {
        return Http::replicate()->get('/trainings', $query);
    }

    /*
     * https://replicate.com/docs/reference/http#trainings.cancel
     */
    public function cancel(string $id): Response
    {
        return Http::replicate()->post("/trainings/$id/cancel");
    }
}
