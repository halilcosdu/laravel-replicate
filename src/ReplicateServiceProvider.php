<?php

namespace HalilCosdu\Replicate;

use Illuminate\Support\Facades\Http;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ReplicateServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-replicate')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        Http::macro('replicate', function () {
            return Http::withHeaders([
                'Accept' => 'application/json',
            ])->withToken(config('replicate.api_token'))
                ->baseUrl(config('replicate.api_url'));
        });
    }
}
