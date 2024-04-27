<?php

namespace HalilCosdu\Replicate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \HalilCosdu\Replicate\Replicate account()
 * @method static \HalilCosdu\Replicate\Replicate getCollection(string $slug)
 * @method static \HalilCosdu\Replicate\Replicate listCollections()
 * @method static \HalilCosdu\Replicate\Replicate listDeployments()
 * @method static \HalilCosdu\Replicate\Replicate createDeployment(array $data)
 * @method static \HalilCosdu\Replicate\Replicate getDeployment(string $owner, string $name)
 * @method static \HalilCosdu\Replicate\Replicate updateDeployment(string $owner, string $name, array $data)
 * @method static \HalilCosdu\Replicate\Replicate listHardware()
 * @method static \HalilCosdu\Replicate\Replicate createModel(array $data)
 * @method static \HalilCosdu\Replicate\Replicate getModel(string $owner, string $name)
 * @method static \HalilCosdu\Replicate\Replicate getModelVersion(string $owner, string $name, string $version)
 * @method static \HalilCosdu\Replicate\Replicate listModelVersions(string $owner, string $name)
 * @method static \HalilCosdu\Replicate\Replicate deleteModelVersion(string $owner, string $name, string $version)
 * @method static \HalilCosdu\Replicate\Replicate listModels()
 * @method static \HalilCosdu\Replicate\Replicate createPrediction(array $data)
 * @method static \HalilCosdu\Replicate\Replicate getPrediction(string $id)
 * @method static \HalilCosdu\Replicate\Replicate cancelPrediction($id)
 * @method static \HalilCosdu\Replicate\Replicate listPredictions()
 * @method static \HalilCosdu\Replicate\Replicate listTrainings()
 * @method static \HalilCosdu\Replicate\Replicate createTraining(string $owner, string $name, string $version, array $data)
 * @method static \HalilCosdu\Replicate\Replicate getTraining(string $id)
 * @method static \HalilCosdu\Replicate\Replicate cancelTraining($id)
 * @method static \HalilCosdu\Replicate\Replicate defaultSecret()
 * @method static \HalilCosdu\Replicate\Replicate createDeploymentPrediction(string $owner, string $name, array $data)
 * @method static \HalilCosdu\Replicate\Replicate createModelPrediction(string $owner, string $name, string $version, array $data)
 *
 * @see \HalilCosdu\Replicate\Replicate
 */
class Replicate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \HalilCosdu\Replicate\Replicate::class;
    }
}
