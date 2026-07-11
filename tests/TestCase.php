<?php

namespace HalilCosdu\Replicate\Tests;

use HalilCosdu\Replicate\ReplicateServiceProvider;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        // Make any un-faked HTTP request fail loudly, so tests stay hermetic.
        Http::preventStrayRequests();
    }

    protected function getPackageProviders($app)
    {
        return [
            ReplicateServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('replicate.api_token', 'test-token');
        config()->set('replicate.api_url', 'https://api.replicate.com/v1');
    }
}
