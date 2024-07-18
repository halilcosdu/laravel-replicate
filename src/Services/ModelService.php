<?php

namespace HalilCosdu\Replicate\Services;

use Illuminate\Support\Facades\Http;

class ModelService
{
    /*
     * https://replicate.com/docs/reference/http#models.create
     */
    public function create(array $data)
    {
        return Http::replicate()->post('/models', $data);
    }

    /*
     * https://replicate.com/docs/reference/http#models.get
     */
    public function get(string $owner, string $name)
    {
        return Http::replicate()->get("/models/$owner/$name");
    }

    /*
     * https://replicate.com/docs/reference/http#models.versions.get
     */
    public function getVersion(string $owner, string $name, string $version)
    {
        return Http::replicate()->get("/models/$owner/$name/versions/$version");
    }

    /*
     * https://replicate.com/docs/reference/http#models.versions.list
     */
    public function listVersions(string $owner, string $name)
    {
        return Http::replicate()->get("/models/$owner/$name/versions");
    }

    /*
     * https://replicate.com/docs/reference/http#models.versions.delete
     */
    public function deleteVersion(string $owner, string $name, string $version)
    {
        return Http::replicate()->delete("/models/$owner/$name/versions/$version");
    }

    /*
     * https://replicate.com/docs/reference/http#models.delete
     */
    public function delete(string $owner, string $name)
    {
        return Http::replicate()->delete("/models/$owner/$name");
    }

    /*
     * https://replicate.com/docs/reference/http#models.list
     */
    public function list()
    {
        return Http::replicate()->get('/models');
    }
}
