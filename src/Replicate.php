<?php

namespace HalilCosdu\Replicate;

use HalilCosdu\Replicate\Services\AuthService;
use HalilCosdu\Replicate\Services\CollectionService;
use HalilCosdu\Replicate\Services\DeploymentService;
use HalilCosdu\Replicate\Services\HardwareService;
use HalilCosdu\Replicate\Services\ModelService;
use HalilCosdu\Replicate\Services\PredictionService;
use HalilCosdu\Replicate\Services\TrainingService;
use HalilCosdu\Replicate\Services\WebhookService;

readonly class Replicate
{
    public function __construct(
        private AuthService $authService,
        private CollectionService $collectionService,
        private DeploymentService $deploymentService,
        private HardwareService $hardwareService,
        private ModelService $modelService,
        private PredictionService $predictionService,
        private TrainingService $trainingService,
        private WebhookService $webhookService,
    ) {
        //
    }

    public function account()
    {
        return $this->authService->account();
    }

    public function getCollection(string $slug)
    {
        return $this->collectionService->get($slug);
    }

    public function listCollections()
    {
        return $this->collectionService->list();
    }

    public function listDeployments()
    {
        return $this->deploymentService->list();
    }

    public function createDeployment(array $data)
    {
        return $this->deploymentService->create($data);
    }

    public function getDeployment(string $owner, string $name)
    {
        return $this->deploymentService->get($owner, $name);
    }

    public function updateDeployment(string $owner, string $name, array $data)
    {
        return $this->deploymentService->update($owner, $name, $data);
    }

    public function listHardware()
    {
        return $this->hardwareService->list();
    }

    public function createModel(array $data)
    {
        return $this->modelService->create($data);
    }

    public function getModel(string $owner, string $name)
    {
        return $this->modelService->get($owner, $name);
    }

    public function getModelVersion(string $owner, string $name, string $version)
    {
        return $this->modelService->getVersion($owner, $name, $version);
    }

    public function listModelVersions(string $owner, string $name)
    {
        return $this->modelService->listVersions($owner, $name);
    }

    public function deleteModelVersion(string $owner, string $name, string $version)
    {
        return $this->modelService->deleteVersion($owner, $name, $version);
    }

    public function listModels()
    {
        return $this->modelService->list();
    }

    public function createPrediction(array $data)
    {
        return $this->predictionService->create($data);
    }

    public function getPrediction(string $id)
    {
        return $this->predictionService->get($id);
    }

    public function cancelPrediction($id)
    {
        return $this->predictionService->cancel($id);
    }

    public function listPredictions()
    {
        return $this->predictionService->list();
    }

    public function listTrainings()
    {
        return $this->trainingService->list();
    }

    public function createTraining(string $owner, string $name, string $version, array $data)
    {
        return $this->trainingService->create($owner, $name, $version, $data);
    }

    public function getTraining(string $id)
    {
        return $this->trainingService->get($id);
    }

    public function cancelTraining($id)
    {
        return $this->trainingService->cancel($id);
    }

    public function defaultSecret()
    {
        return $this->webhookService->defaultSecret();
    }

    public function createDeploymentPrediction(string $owner, string $name, array $data)
    {
        return $this->predictionService->createDeploymentPrediction($owner, $name, $data);
    }

    public function createModelPrediction(string $owner, string $name, string $version, array $data)
    {
        return $this->predictionService->createModelPrediction($owner, $name, $version, $data);
    }
}
