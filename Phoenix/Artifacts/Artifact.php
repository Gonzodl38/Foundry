<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path:
 * C:\Projects\Phoenix\Artifacts\Artifact.php
 *
 * Artifact ID:
 * ARTIFACT-000006
 *
 * File ID:
 * FILE-000006
 *
 * Title:
 * Base Artifact
 *
 * Description:
 * Abstract base class for every governed Artifact managed by PEOS.
 *
 * Work Order:
 * WO-000004
 *
 * Specification:
 * SPEC-000001
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

namespace Phoenix\Artifacts;

use DateTimeImmutable;
use Phoenix\Artifacts\Contracts\ArtifactContract;
use Phoenix\Artifacts\DTO\ArtifactManifest;
use Phoenix\Artifacts\Enums\ArtifactStatus;
use Phoenix\Artifacts\Enums\ArtifactType;

abstract class Artifact implements ArtifactContract
{
    protected ArtifactManifest $manifest;

    public function __construct(ArtifactManifest $manifest)
    {
        $this->manifest = $manifest;
    }

    public function getId(): ArtifactId
    {
        return $this->manifest->id;
    }

    public function getType(): ArtifactType
    {
        return $this->manifest->type;
    }

    public function getStatus(): ArtifactStatus
    {
        return $this->manifest->status;
    }

    public function setStatus(ArtifactStatus $status): void
    {
        $this->manifest = new ArtifactManifest(
            id: $this->manifest->id,
            type: $this->manifest->type,
            status: $status,
            title: $this->manifest->title,
            description: $this->manifest->description,
            version: $this->manifest->version,
            workOrder: $this->manifest->workOrder,
            specification: $this->manifest->specification,
            authors: $this->manifest->authors,
            dependencies: $this->manifest->dependencies,
            metadata: $this->manifest->metadata,
            createdAt: $this->manifest->createdAt(),
            updatedAt: new DateTimeImmutable(),
        );
    }

    public function getTitle(): string
    {
        return $this->manifest->title;
    }

    public function getDescription(): string
    {
        return $this->manifest->description;
    }

    public function getVersion(): string
    {
        return $this->manifest->version;
    }

    public function getManifest(): ArtifactManifest
    {
        return $this->manifest;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->manifest->createdAt();
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->manifest->updatedAt();
    }

    public function touch(): void
    {
        $this->setStatus($this->getStatus());
    }

    public function isManufacturable(): bool
    {
        return $this->getStatus()->canManufacture();
    }

    public function isVerifiable(): bool
    {
        return $this->getStatus()->canVerify();
    }

    public function isCertifiable(): bool
    {
        return $this->getStatus()->canCertify();
    }

    public function toArray(): array
    {
        return $this->manifest->toArray();
    }

    /**
     * Returns the canonical Artifact name.
     */
    abstract public function name(): string;
}