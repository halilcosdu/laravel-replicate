<?php

namespace HalilCosdu\Replicate\Services;

use HalilCosdu\Replicate\Facades\Http;
use Illuminate\Http\Client\Response;

class DeploymentService
{
    /*
    * https://replicate.com/docs/reference/http#deployments.list
    */
    public function list(array $query = []): Response
    {
        return Http::replicate()->get('/deployments', $query);
    }

    /*
     * https://replicate.com/docs/reference/http#deployments.create
     */
    public function create(array $data): Response
    {
        return Http::replicate()->post('/deployments', $data);
    }

    /*
     * https://replicate.com/docs/reference/http#deployments.get
     */
    public function get(string $owner, string $name): Response
    {
        return Http::replicate()->get("/deployments/$owner/$name");
    }

    /*
     * https://replicate.com/docs/reference/http#deployments.update
     */
    public function update(string $owner, string $name, array $data): Response
    {
        return Http::replicate()->patch("/deployments/$owner/$name", $data);
    }

    /*
     * https://replicate.com/docs/reference/http#deployments.delete
     */
    public function delete(string $owner, string $name): Response
    {
        return Http::replicate()->delete("/deployments/$owner/$name");
    }
}
