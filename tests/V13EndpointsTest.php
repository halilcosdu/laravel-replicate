<?php

use HalilCosdu\Replicate\Facades\Replicate;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::fake();
});

describe('search', function () {
    it('GETs /search with the query', function () {
        Replicate::search('nano banana');

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && str_contains($request->url(), '/search')
            && str_contains($request->url(), 'query=nano'));
    });

    it('forwards the limit parameter when provided', function () {
        Replicate::search('nano banana', 5);

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && str_contains($request->url(), 'limit=5')
            && str_contains($request->url(), 'query=nano'));
    });
});

describe('models.update', function () {
    it('PATCHes model metadata', function () {
        Replicate::updateModel('alice', 'detector', ['description' => 'updated']);

        Http::assertSent(fn ($request) => $request->method() === 'PATCH'
            && $request->url() === 'https://api.replicate.com/v1/models/alice/detector'
            && $request['description'] === 'updated');
    });
});

describe('models.search', function () {
    it('sends a QUERY request with a text/plain body', function () {
        Replicate::searchModels('hello');

        Http::assertSent(fn ($request) => $request->method() === 'QUERY'
            && $request->url() === 'https://api.replicate.com/v1/models'
            && $request->body() === 'hello'
            && $request->hasHeader('Content-Type', 'text/plain'));
    });
});

describe('models.examples.list', function () {
    it('lists model examples', function () {
        Replicate::listModelExamples('alice', 'detector');

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/models/alice/detector/examples');
    });

    it('forwards query parameters', function () {
        Replicate::listModelExamples('alice', 'detector', ['cursor' => 'abc']);

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && str_contains($request->url(), 'cursor=abc'));
    });
});

describe('models.readme.get', function () {
    it('gets the model readme', function () {
        Replicate::getModelReadme('alice', 'detector');

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/models/alice/detector/readme');
    });
});

describe('deployments.delete', function () {
    it('deletes a deployment', function () {
        Replicate::deleteDeployment('alice', 'my-deployment');

        Http::assertSent(fn ($request) => $request->method() === 'DELETE'
            && $request->url() === 'https://api.replicate.com/v1/deployments/alice/my-deployment');
    });
});

describe('prediction headers', function () {
    it('forwards Prefer and Cancel-After headers on createPrediction', function () {
        Replicate::createPrediction(
            ['version' => 'abc', 'input' => ['text' => 'hi']],
            ['Prefer' => 'wait=60', 'Cancel-After' => '5m']
        );

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.replicate.com/v1/predictions'
            && $request->hasHeader('Prefer', 'wait=60')
            && $request->hasHeader('Cancel-After', '5m'));
    });

    it('forwards headers on createModelPrediction', function () {
        Replicate::createModelPrediction('meta', 'llama-3', 'v1', ['input' => []], ['Prefer' => 'wait=10']);

        Http::assertSent(fn ($request) => $request->hasHeader('Prefer', 'wait=10'));
    });

    it('forwards headers on createDeploymentPrediction', function () {
        Replicate::createDeploymentPrediction('alice', 'dep', ['input' => []], ['Cancel-After' => '30s']);

        Http::assertSent(fn ($request) => $request->hasHeader('Cancel-After', '30s'));
    });

    it('omits extra headers when none are passed (backwards compatible)', function () {
        Replicate::createPrediction(['version' => 'abc']);

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.replicate.com/v1/predictions');
    });
});

describe('list query parameters', function () {
    it('forwards filters on listPredictions', function () {
        Replicate::listPredictions(['created_after' => '2024-01-01T00:00:00Z']);

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && str_contains($request->url(), 'created_after=2024-01-01'));
    });

    it('forwards sort on listModels', function () {
        Replicate::listModels(['sort_by' => 'model_created_at', 'sort_direction' => 'desc']);

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && str_contains($request->url(), 'sort_by=model_created_at')
            && str_contains($request->url(), 'sort_direction=desc'));
    });

    it('forwards cursor on listTrainings', function () {
        Replicate::listTrainings(['cursor' => 'page2']);

        Http::assertSent(fn ($request) => str_contains($request->url(), 'cursor=page2'));
    });

    it('sends a bare request when no query is passed (backwards compatible)', function () {
        Replicate::listModels();

        Http::assertSent(fn ($request) => $request->url() === 'https://api.replicate.com/v1/models');
    });
});
