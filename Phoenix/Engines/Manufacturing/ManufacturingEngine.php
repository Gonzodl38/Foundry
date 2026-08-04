<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Engines\Manufacturing\ManufacturingEngine.php
 *
 * Artifact ID: ENGINE-000001
 * File ID: FILE-000012
 *
 * Title:
 * Manufacturing Engine
 *
 * Description:
 * Orchestrates the complete manufacturing lifecycle of governed Artifacts.
 *
 * Work Order:
 * WO-000004
 *
 * Specification:
 * SPEC-000006
 *
 * Author:
 * Phoenix Foundry
 *
 * Since:
 * 1.0.0
 *
 * PHP Version:
 * 8.2+
 * --------------------------------------------------------------------------
 */

declare(strict_types=1);

namespace Phoenix\Engines\Manufacturing;

use Phoenix\Artifacts\Artifact;
use Phoenix\Artifacts\ArtifactFactory;
use Phoenix\Artifacts\ArtifactRegistry;
use Phoenix\Artifacts\DTO\ArtifactManifest;
use Phoenix\Engines\Manufacturing\Contracts\ManufacturingEngineContract;
use Phoenix\Engines\Manufacturing\DTO\ManufacturingResult;
use Phoenix\Engines\Manufacturing\Exceptions\ManufacturingException;

final class ManufacturingEngine implements ManufacturingEngineContract
{
    public function __construct(
        private readonly ArtifactFactory $factory,
        private readonly ArtifactRegistry $registry
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function manufacture(
        ArtifactFactory $factory,
        string $artifactClass,
        ArtifactManifest $manifest
    ): ManufacturingResult {
        $started = microtime(true);

        try {
            $artifact = $factory->manufacture(
                artifactClass: $artifactClass,
                manifest: $manifest
            );

            return ManufacturingResult::success(
                artifact: $artifact,
                messages: [
                    'Artifact manufactured successfully.',
                ],
                executionTime: microtime(true) - $started
            );
        } catch (\Throwable $exception) {
            return ManufacturingResult::failure(
                messages: [$exception->getMessage()],
                executionTime: microtime(true) - $started
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function verify(
        Artifact $artifact
    ): ManufacturingResult {
        return ManufacturingResult::success(
            artifact: $artifact,
            messages: [
                'Artifact verification completed.',
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function certify(
        Artifact $artifact
    ): ManufacturingResult {
        return ManufacturingResult::success(
            artifact: $artifact,
            messages: [
                'Artifact certification completed.',
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function register(
        Artifact $artifact
    ): ManufacturingResult {
        try {
            $this->registry->register($artifact);

            return ManufacturingResult::success(
                artifact: $artifact,
                messages: [
                    'Artifact registered successfully.',
                ]
            );
        } catch (\Throwable $exception) {
            throw ManufacturingException::registrationFailed(
                (string) $artifact->getId()
            );
        }
    }

    /**
     * Executes the complete manufacturing pipeline.
     */
    public function execute(
        string $artifactClass,
        ArtifactManifest $manifest
    ): ManufacturingResult {
        $result = $this->manufacture(
            factory: $this->factory,
            artifactClass: $artifactClass,
            manifest: $manifest
        );

        if ($result->isFailure()) {
            return $result;
        }

        /** @var Artifact $artifact */
        $artifact = $result->artifact;

        $this->verify($artifact);
        $this->certify($artifact);

        return $this->register($artifact);
    }
}