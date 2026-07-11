<?php

namespace HalilCosdu\Replicate\Facades;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Response account()
 * @method static Response getCollection(string $slug)
 * @method static Response listCollections(array $query = [])
 * @method static Response listDeployments(array $query = [])
 * @method static Response createDeployment(array $data)
 * @method static Response getDeployment(string $owner, string $name)
 * @method static Response updateDeployment(string $owner, string $name, array $data)
 * @method static Response deleteDeployment(string $owner, string $name)
 * @method static Response createFile(mixed $contents, string $filename, string $contentType = 'application/octet-stream', array $metadata = [])
 * @method static Response listFiles(array $query = [])
 * @method static Response getFile(string $id)
 * @method static Response deleteFile(string $id)
 * @method static Response downloadFile(string $id, string $owner, int $expiry, string $signature)
 * @method static Response listHardware()
 * @method static Response createModel(array $data)
 * @method static Response getModel(string $owner, string $name)
 * @method static Response getModelVersion(string $owner, string $name, string $version)
 * @method static Response listModelVersions(string $owner, string $name)
 * @method static Response deleteModelVersion(string $owner, string $name, string $version)
 * @method static Response deleteModel(string $owner, string $name)
 * @method static Response listModels(array $query = [])
 * @method static Response updateModel(string $owner, string $name, array $data)
 * @method static Response searchModels(string $query)
 * @method static Response listModelExamples(string $owner, string $name, array $query = [])
 * @method static Response getModelReadme(string $owner, string $name)
 * @method static Response createPrediction(array $data, array $headers = [])
 * @method static Response getPrediction(string $id)
 * @method static Response cancelPrediction(string $id)
 * @method static Response listPredictions(array $query = [])
 * @method static Response createDeploymentPrediction(string $owner, string $name, array $data, array $headers = [])
 * @method static Response createModelPrediction(string $owner, string $name, string $version, array $data, array $headers = [])
 * @method static Response createOfficialModelPrediction(string $owner, string $name, array $data, array $headers = [])
 * @method static Response listTrainings(array $query = [])
 * @method static Response createTraining(string $owner, string $name, string $version, array $data)
 * @method static Response getTraining(string $id)
 * @method static Response cancelTraining(string $id)
 * @method static Response defaultSecret()
 * @method static Response search(string $query, ?int $limit = null)
 * @method static bool verifyWebhook(Request $request, ?string $secret = null, ?int $tolerance = null)
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
