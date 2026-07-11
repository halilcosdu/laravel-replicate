<?php

namespace HalilCosdu\Replicate\Services;

use HalilCosdu\Replicate\Facades\Http;
use Illuminate\Http\Client\Response;

class ModelService
{
    /*
     * https://replicate.com/docs/reference/http#models.create
     */
    public function create(array $data): Response
    {
        return Http::replicate()->post('/models', $data);
    }

    /*
     * https://replicate.com/docs/reference/http#models.get
     */
    public function get(string $owner, string $name): Response
    {
        return Http::replicate()->get("/models/$owner/$name");
    }

    /*
     * https://replicate.com/docs/reference/http#models.versions.get
     */
    public function getVersion(string $owner, string $name, string $version): Response
    {
        return Http::replicate()->get("/models/$owner/$name/versions/$version");
    }

    /*
     * https://replicate.com/docs/reference/http#models.versions.list
     */
    public function listVersions(string $owner, string $name): Response
    {
        return Http::replicate()->get("/models/$owner/$name/versions");
    }

    /*
     * https://replicate.com/docs/reference/http#models.versions.delete
     */
    public function deleteVersion(string $owner, string $name, string $version): Response
    {
        return Http::replicate()->delete("/models/$owner/$name/versions/$version");
    }

    /*
     * https://replicate.com/docs/reference/http#models.delete
     */
    public function delete(string $owner, string $name): Response
    {
        return Http::replicate()->delete("/models/$owner/$name");
    }

    /*
     * https://replicate.com/docs/reference/http#models.list
     */
    public function list(array $query = []): Response
    {
        return Http::replicate()->get('/models', $query);
    }

    /*
     * https://replicate.com/docs/reference/http#models.update
     */
    public function update(string $owner, string $name, array $data): Response
    {
        return Http::replicate()->patch("/models/$owner/$name", $data);
    }

    /*
     * https://replicate.com/docs/reference/http#models.search
     * Uses the non-standard QUERY HTTP method with a raw text/plain body.
     */
    public function search(string $query): Response
    {
        return Http::replicate()
            ->withBody($query, 'text/plain')
            ->send('QUERY', '/models');
    }

    /*
     * https://replicate.com/docs/reference/http#models.examples.list
     */
    public function listExamples(string $owner, string $name, array $query = []): Response
    {
        return Http::replicate()->get("/models/$owner/$name/examples", $query);
    }

    /*
     * https://replicate.com/docs/reference/http#models.readme.get
     * Returns the README as plain-text Markdown (not JSON).
     */
    public function readme(string $owner, string $name): Response
    {
        return Http::replicate()->get("/models/$owner/$name/readme");
    }
}
