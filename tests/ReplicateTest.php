<?php

use HalilCosdu\Replicate\Facades\Replicate;
use HalilCosdu\Replicate\Replicate as ReplicateService;

it('can resolve the replicate service from the container', function () {
    expect(app(ReplicateService::class))->toBeInstanceOf(ReplicateService::class);
});

it('can resolve the replicate facade', function () {
    expect(Replicate::getFacadeRoot())->toBeInstanceOf(ReplicateService::class);
});
