<?php

namespace HalilCosdu\Replicate;

use HalilCosdu\Replicate\Services\AuthService;
use HalilCosdu\Replicate\Services\CollectionService;
use HalilCosdu\Replicate\Services\DeploymentService;
use HalilCosdu\Replicate\Services\FileService;
use HalilCosdu\Replicate\Services\HardwareService;
use HalilCosdu\Replicate\Services\ModelService;
use HalilCosdu\Replicate\Services\PredictionService;
use HalilCosdu\Replicate\Services\SearchService;
use HalilCosdu\Replicate\Services\TrainingService;
use HalilCosdu\Replicate\Services\WebhookService;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use LogicException;

readonly class Replicate
{
    public function __construct(
        private AuthService $authService,
        private CollectionService $collectionService,
        private DeploymentService $deploymentService,
        private FileService $fileService,
        private HardwareService $hardwareService,
        private ModelService $modelService,
        private PredictionService $predictionService,
        private SearchService $searchService,
        private TrainingService $trainingService,
        private WebhookService $webhookService,
        private WebhookVerifier $webhookVerifier,
    ) {
        //
    }

    public function account(): Response
    {
        return $this->authService->account();
    }

    public function getCollection(string $slug): Response
    {
        return $this->collectionService->get($slug);
    }

    public function listCollections(array $query = []): Response
    {
        return $this->collectionService->list($query);
    }

    public function listDeployments(array $query = []): Response
    {
        return $this->deploymentService->list($query);
    }

    public function createDeployment(array $data): Response
    {
        return $this->deploymentService->create($data);
    }

    public function getDeployment(string $owner, string $name): Response
    {
        return $this->deploymentService->get($owner, $name);
    }

    public function updateDeployment(string $owner, string $name, array $data): Response
    {
        return $this->deploymentService->update($owner, $name, $data);
    }

    public function deleteDeployment(string $owner, string $name): Response
    {
        return $this->deploymentService->delete($owner, $name);
    }

    /**
     * @param  resource|string  $contents
     * @param  array<string, mixed>  $metadata
     */
    public function createFile(
        mixed $contents,
        string $filename,
        string $contentType = 'application/octet-stream',
        array $metadata = [],
    ): Response {
        return $this->fileService->create($contents, $filename, $contentType, $metadata);
    }

    public function listFiles(array $query = []): Response
    {
        return $this->fileService->list($query);
    }

    public function getFile(string $id): Response
    {
        return $this->fileService->get($id);
    }

    public function deleteFile(string $id): Response
    {
        return $this->fileService->delete($id);
    }

    public function downloadFile(string $id, string $owner, int $expiry, string $signature): Response
    {
        return $this->fileService->download($id, $owner, $expiry, $signature);
    }

    public function listHardware(): Response
    {
        return $this->hardwareService->list();
    }

    public function createModel(array $data): Response
    {
        return $this->modelService->create($data);
    }

    public function getModel(string $owner, string $name): Response
    {
        return $this->modelService->get($owner, $name);
    }

    public function getModelVersion(string $owner, string $name, string $version): Response
    {
        return $this->modelService->getVersion($owner, $name, $version);
    }

    public function listModelVersions(string $owner, string $name): Response
    {
        return $this->modelService->listVersions($owner, $name);
    }

    public function deleteModelVersion(string $owner, string $name, string $version): Response
    {
        return $this->modelService->deleteVersion($owner, $name, $version);
    }

    public function deleteModel(string $owner, string $name): Response
    {
        return $this->modelService->delete($owner, $name);
    }

    public function listModels(array $query = []): Response
    {
        return $this->modelService->list($query);
    }

    public function updateModel(string $owner, string $name, array $data): Response
    {
        return $this->modelService->update($owner, $name, $data);
    }

    public function searchModels(string $query): Response
    {
        return $this->modelService->search($query);
    }

    public function listModelExamples(string $owner, string $name, array $query = []): Response
    {
        return $this->modelService->listExamples($owner, $name, $query);
    }

    public function getModelReadme(string $owner, string $name): Response
    {
        return $this->modelService->readme($owner, $name);
    }

    public function createPrediction(array $data, array $headers = []): Response
    {
        return $this->predictionService->create($data, $headers);
    }

    public function getPrediction(string $id): Response
    {
        return $this->predictionService->get($id);
    }

    public function cancelPrediction(string $id): Response
    {
        return $this->predictionService->cancel($id);
    }

    public function listPredictions(array $query = []): Response
    {
        return $this->predictionService->list($query);
    }

    public function listTrainings(array $query = []): Response
    {
        return $this->trainingService->list($query);
    }

    public function createTraining(string $owner, string $name, string $version, array $data): Response
    {
        return $this->trainingService->create($owner, $name, $version, $data);
    }

    public function getTraining(string $id): Response
    {
        return $this->trainingService->get($id);
    }

    public function cancelTraining(string $id): Response
    {
        return $this->trainingService->cancel($id);
    }

    public function defaultSecret(): Response
    {
        return $this->webhookService->defaultSecret();
    }

    public function createDeploymentPrediction(string $owner, string $name, array $data, array $headers = []): Response
    {
        return $this->predictionService->createDeploymentPrediction($owner, $name, $data, $headers);
    }

    /**
     * @deprecated Use createOfficialModelPrediction(). Replicate's official-model endpoint has no version path parameter.
     */
    public function createModelPrediction(string $owner, string $name, string $version, array $data, array $headers = []): Response
    {
        return $this->predictionService->createModelPrediction($owner, $name, $version, $data, $headers);
    }

    public function createOfficialModelPrediction(string $owner, string $name, array $data, array $headers = []): Response
    {
        return $this->predictionService->createOfficialModelPrediction($owner, $name, $data, $headers);
    }

    public function search(string $query, ?int $limit = null): Response
    {
        return $this->searchService->search($query, $limit);
    }

    public function verifyWebhook(Request $request, ?string $secret = null, ?int $tolerance = null): bool
    {
        $secret ??= config('replicate.webhook_secret');

        if (! is_string($secret) || $secret === '') {
            throw new LogicException(
                'A Replicate webhook secret is required. Set REPLICATE_WEBHOOK_SECRET or pass a secret explicitly.'
            );
        }

        if ($tolerance === null) {
            $configuredTolerance = config('replicate.webhook_tolerance', 300);
            $tolerance = is_numeric($configuredTolerance) ? (int) $configuredTolerance : 300;
        }

        return $this->webhookVerifier->verify($request, $secret, $tolerance);
    }
}
