<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path:
 * C:\Projects\Phoenix\Artifacts\DTO\ArtifactManifest.php
 *
 * Artifact ID:
 * ARTIFACT-000005
 *
 * File ID:
 * FILE-000005
 *
 * Title:
 * Artifact Manifest
 *
 * Description:
 * Immutable metadata describing a governed Artifact.
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

namespace Phoenix\Artifacts\DTO;

use DateTimeImmutable;
use JsonSerializable;
use Phoenix\Artifacts\ArtifactId;
use Phoenix\Artifacts\Enums\ArtifactStatus;
use Phoenix\Artifacts\Enums\ArtifactType;

final readonly class ArtifactManifest implements JsonSerializable
{
    /**
     * @param array<string> $authors
     * @param array<ArtifactId> $dependencies
     * @param array<string,string> $metadata
     */
    public function __construct(
        public ArtifactId $id,
        public ArtifactType $type,
        public ArtifactStatus $status,
        public string $title,
        public string $description,
        public string $version,
        public string $workOrder,
        public string $specification,
        public array $authors = [],
        public array $dependencies = [],
        public array $metadata = [],
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    /**
     * Returns the creation timestamp.
     */
    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt ?? new DateTimeImmutable();
    }

    /**
     * Returns the last update timestamp.
     */
    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt ?? $this->createdAt();
    }

    /**
     * Returns true when the manifest has dependencies.
     */
    public function hasDependencies(): bool
    {
        return $this->dependencies !== [];
    }

    /**
     * Returns true when custom metadata exists.
     */
    public function hasMetadata(): bool
    {
        return $this->metadata !== [];
    }

    /**
     * Returns the manifest as an array.
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => (string) $this->id,
            'type' => $this->type->value,
            'prefix' => $this->type->prefix(),
            'status' => $this->status->value,
            'title' => $this->title,
            'description' => $this->description,
            'version' => $this->version,
            'workOrder' => $this->workOrder,
            'specification' => $this->specification,
            'authors' => $this->authors,
            'dependencies' => array_map(
                static fn (ArtifactId $id): string => (string) $id,
                $this->dependencies
            ),
            'metadata' => $this->metadata,
            'createdAt' => $this->createdAt()->format(DATE_ATOM),
            'updatedAt' => $this->updatedAt()->format(DATE_ATOM),
        ];
    }

    /**
     * Returns the manifest as JSON.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}