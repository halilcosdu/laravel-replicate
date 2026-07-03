<?php

use Illuminate\Support\Facades\Http;

describe('Http::replicate macro', function () {
    it('targets the configured base url', function () {
        Http::fake();

        Http::replicate()->get('/account');

        Http::assertSent(fn ($request) => $request->url() === 'https://api.replicate.com/v1/account');
    });

    it('sends the api token as a bearer token', function () {
        Http::fake();

        Http::replicate()->get('/account');

        Http::assertSent(fn ($request) => $request->hasHeader('Authorization', 'Bearer test-token'));
    });

    it('sends the json accept header', function () {
        Http::fake();

        Http::replicate()->get('/account');

        Http::assertSent(fn ($request) => $request->hasHeader('Accept', 'application/json'));
    });

    it('respects a custom api url', function () {
        config(['replicate.api_url' => 'https://custom.replicate.test/v1']);
        Http::fake();

        Http::replicate()->get('/account');

        Http::assertSent(fn ($request) => $request->url() === 'https://custom.replicate.test/v1/account');
    });
});
