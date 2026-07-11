<?php

use HalilCosdu\Replicate\Facades\Replicate;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::fake();
});

describe('files', function () {
    it('creates a multipart file with metadata', function () {
        Replicate::createFile(
            contents: 'file contents',
            filename: 'prompt.txt',
            contentType: 'text/plain',
            metadata: ['job_id' => 123],
        );

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.replicate.com/v1/files'
            && str_contains($request->body(), 'name="content"')
            && str_contains($request->body(), 'filename="prompt.txt"')
            && str_contains($request->body(), 'Content-Type: text/plain')
            && str_contains($request->body(), 'file contents')
            && str_contains($request->body(), 'name="metadata"')
            && str_contains($request->body(), '{"job_id":123}'));
    });

    it('lists files with pagination parameters', function () {
        Replicate::listFiles(['cursor' => 'next-page']);

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && str_contains($request->url(), '/files')
            && str_contains($request->url(), 'cursor=next-page'));
    });

    it('gets a file', function () {
        Replicate::getFile('file-123');

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/files/file-123');
    });

    it('deletes a file', function () {
        Replicate::deleteFile('file-123');

        Http::assertSent(fn ($request) => $request->method() === 'DELETE'
            && $request->url() === 'https://api.replicate.com/v1/files/file-123');
    });

    it('downloads a file with its signed query parameters', function () {
        Replicate::downloadFile('file-123', 'alice', 1_800_000_000, 'signed/value=');

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && str_contains($request->url(), '/files/file-123/download')
            && str_contains($request->url(), 'owner=alice')
            && str_contains($request->url(), 'expiry=1800000000')
            && str_contains($request->url(), 'signature=signed%2Fvalue%3D'));
    });
});
