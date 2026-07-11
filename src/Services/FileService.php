<?php

namespace HalilCosdu\Replicate\Services;

use HalilCosdu\Replicate\Facades\Http;
use Illuminate\Http\Client\Response;

class FileService
{
    /*
     * https://replicate.com/docs/reference/http#files.create
     *
     * @param  resource|string  $contents
     * @param  array<string, mixed>  $metadata
     */
    public function create(
        mixed $contents,
        string $filename,
        string $contentType = 'application/octet-stream',
        array $metadata = [],
    ): Response {
        return Http::replicate()
            ->attach('content', $contents, $filename, ['Content-Type' => $contentType])
            ->attach('metadata', json_encode($metadata, JSON_THROW_ON_ERROR), null, ['Content-Type' => 'application/json'])
            ->post('/files');
    }

    /*
     * https://replicate.com/docs/reference/http#files.list
     */
    public function list(array $query = []): Response
    {
        return Http::replicate()->get('/files', $query);
    }

    /*
     * https://replicate.com/docs/reference/http#files.get
     */
    public function get(string $id): Response
    {
        return Http::replicate()->get("/files/$id");
    }

    /*
     * https://replicate.com/docs/reference/http#files.delete
     */
    public function delete(string $id): Response
    {
        return Http::replicate()->delete("/files/$id");
    }

    /*
     * https://replicate.com/docs/reference/http#files.download
     */
    public function download(string $id, string $owner, int $expiry, string $signature): Response
    {
        return Http::replicate()->get("/files/$id/download", [
            'owner' => $owner,
            'expiry' => $expiry,
            'signature' => $signature,
        ]);
    }
}
