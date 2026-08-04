<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Engines\Manufacturing\Contracts\ManufacturingEngineContract.php
 *
 * Artifact ID: CONTRACT-000002
 * File ID: FILE-000009
 *
 * Title:
 * Manufacturing Engine Contract
 *
 * Description:
 * Defines the public contract implemented by every Manufacturing Engine.
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

namespace Phoenix\Engines\Manufacturing\Contracts;

use Phoenix\Artifacts\Artifact;
use Phoenix\Artifacts\ArtifactFactory;
use Phoenix\Artifacts\DTO\ArtifactManifest;
use Phoenix\Engines\Manufacturing\DTO\ManufacturingResult;

interface ManufacturingEngineContract
{
    /**
     * Manufactures an Artifact.
     *
     * @template T of Artifact
     *
     * @param class-string<T> $artifactClass
     *
     * @return ManufacturingResult
     */
    public function manufacture(
        ArtifactFactory $factory,
        string $artifactClass,
        ArtifactManifest $manifest
    ): ManufacturingResult;

    /**
     * Verifies a manufactured Artifact.
     */
    public function verify(
        Artifact $artifact
    ): ManufacturingResult;

    /**
     * Certifies a manufactured Artifact.
     */
    public function certify(
        Artifact $artifact
    ): ManufacturingResult;

    /**
     * Registers a manufactured Artifact.
     */
    public function register(
        Artifact $artifact
    ): ManufacturingResult;
}