<?php

use HalilCosdu\Replicate\Facades\Replicate;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::fake();
});

describe('account', function () {
    it('GETs /account', function () {
        Replicate::account();

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/account');
    });
});

describe('collections', function () {
    it('GETs a collection by slug', function () {
        Replicate::getCollection('super-resolution');

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/collections/super-resolution');
    });

    it('lists collections', function () {
        Replicate::listCollections();

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/collections');
    });
});

describe('deployments', function () {
    it('lists deployments', function () {
        Replicate::listDeployments();

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/deployments');
    });

    it('creates a deployment', function () {
        Replicate::createDeployment(['name' => 'my-deployment']);

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.replicate.com/v1/deployments'
            && $request['name'] === 'my-deployment');
    });

    it('gets a deployment', function () {
        Replicate::getDeployment('alice', 'my-deployment');

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/deployments/alice/my-deployment');
    });

    it('updates a deployment', function () {
        Replicate::updateDeployment('alice', 'my-deployment', ['min_instances' => 2]);

        Http::assertSent(fn ($request) => $request->method() === 'PATCH'
            && $request->url() === 'https://api.replicate.com/v1/deployments/alice/my-deployment'
            && $request['min_instances'] === 2);
    });
});

describe('hardware', function () {
    it('lists hardware', function () {
        Replicate::listHardware();

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/hardware');
    });
});

describe('models', function () {
    it('creates a model', function () {
        Replicate::createModel(['owner' => 'alice', 'name' => 'detector']);

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.replicate.com/v1/models'
            && $request['name'] === 'detector');
    });

    it('gets a model', function () {
        Replicate::getModel('alice', 'detector');

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/models/alice/detector');
    });

    it('lists models', function () {
        Replicate::listModels();

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/models');
    });

    it('deletes a model', function () {
        Replicate::deleteModel('alice', 'detector');

        Http::assertSent(fn ($request) => $request->method() === 'DELETE'
            && $request->url() === 'https://api.replicate.com/v1/models/alice/detector');
    });

    it('gets a model version', function () {
        Replicate::getModelVersion('alice', 'detector', 'abc123');

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/models/alice/detector/versions/abc123');
    });

    it('lists model versions', function () {
        Replicate::listModelVersions('alice', 'detector');

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/models/alice/detector/versions');
    });

    it('deletes a model version', function () {
        Replicate::deleteModelVersion('alice', 'detector', 'abc123');

        Http::assertSent(fn ($request) => $request->method() === 'DELETE'
            && $request->url() === 'https://api.replicate.com/v1/models/alice/detector/versions/abc123');
    });
});

describe('predictions', function () {
    it('creates a prediction', function () {
        Replicate::createPrediction(['version' => 'abc', 'input' => ['text' => 'hi']]);

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.replicate.com/v1/predictions'
            && $request['version'] === 'abc');
    });

    it('gets a prediction', function () {
        Replicate::getPrediction('pred-1');

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/predictions/pred-1');
    });

    it('lists predictions', function () {
        Replicate::listPredictions();

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/predictions');
    });

    it('cancels a prediction', function () {
        Replicate::cancelPrediction('pred-1');

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.replicate.com/v1/predictions/pred-1/cancel');
    });

    it('creates a deployment prediction', function () {
        Replicate::createDeploymentPrediction('alice', 'my-deployment', ['input' => ['prompt' => 'x']]);

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.replicate.com/v1/deployments/alice/my-deployment/predictions');
    });

    it('creates an official model prediction', function () {
        Replicate::createModelPrediction('meta', 'llama-3', 'v1', ['input' => ['prompt' => 'x']]);

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.replicate.com/v1/models/meta/llama-3/predictions');
    });

    it('creates an official model prediction without a legacy version argument', function () {
        Replicate::createOfficialModelPrediction('meta', 'llama-3', ['input' => ['prompt' => 'x']]);

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.replicate.com/v1/models/meta/llama-3/predictions');
    });
});

describe('trainings', function () {
    it('lists trainings', function () {
        Replicate::listTrainings();

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/trainings');
    });

    it('creates a training', function () {
        Replicate::createTraining('alice', 'detector', 'v1', ['destination' => 'alice/detector-finetune']);

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.replicate.com/v1/models/alice/detector/versions/v1/trainings'
            && $request['destination'] === 'alice/detector-finetune');
    });

    it('gets a training', function () {
        Replicate::getTraining('training-1');

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/trainings/training-1');
    });

    it('cancels a training', function () {
        Replicate::cancelTraining('training-1');

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.replicate.com/v1/trainings/training-1/cancel');
    });
});

describe('webhooks', function () {
    it('gets the default webhook secret', function () {
        Replicate::defaultSecret();

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'https://api.replicate.com/v1/webhooks/default/secret');
    });
});
