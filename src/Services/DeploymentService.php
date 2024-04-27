<?php

namespace HalilCosdu\Replicate\Services;

use Illuminate\Support\Facades\Http;

class DeploymentService
{
    /*
    * https://replicate.com/docs/reference/http#deployments.list
    */
    public function list()
    {
        return Http::replicate()->get('/deployments');
    }

    /*
     * https://replicate.com/docs/reference/http#deployments.create
     */
    public function create(array $data)
    {
        return Http::replicate()->post('/deployments', $data);
    }

    /*
     * https://replicate.com/docs/reference/http#deployments.get
     */
    public function get(string $owner, string $name)
    {
        return Http::replicate()->get("/deployments/$owner/$name");
    }

    /*
     * https://replicate.com/docs/reference/http#deployments.update
     */
    public function update(string $owner, string $name, array $data)
    {
        return Http::replicate()->patch("/deployments/$owner/$name", $data);
    }
}
