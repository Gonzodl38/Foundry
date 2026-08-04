<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path:
 * C:\Projects\Phoenix\Artifacts\Contracts\ArtifactContract.php
 *
 * Artifact ID:
 * CONTRACT-000001
 *
 * File ID:
 * FILE-000001
 *
 * Title:
 * Artifact Contract
 *
 * Description:
 * Defines the minimum behavior required for every governed Artifact
 * managed by the Phoenix Engineering Operating System.
 *
 * Work Order:
 * WO-000004
 *
 * Specification:
 * SPEC-000002
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

namespace Phoenix\Artifacts\Contracts;

use DateTimeImmutable;
use Phoenix\Artifacts\ArtifactId;
use Phoenix\Artifacts\DTO\ArtifactManifest;
use Phoenix\Artifacts\Enums\ArtifactStatus;
use Phoenix\Artifacts\Enums\ArtifactType;

/**
 * Contract implemented by every governed artifact.
 */
interface ArtifactContract
{
    /**
     * Returns the unique Artifact identifier.
     */
    public function getId(): ArtifactId;

    /**
     * Returns the Artifact type.
     */
    public function getType(): ArtifactType;

    /**
     * Returns the current Artifact status.
     */
    public function getStatus(): ArtifactStatus;

    /**
     * Updates the Artifact status.
     */
    public function setStatus(ArtifactStatus $status): void;

    /**
     * Returns the Artifact title.
     */
    public function getTitle(): string;

    /**
     * Returns the Artifact description.
     */
    public function getDescription(): string;

    /**
     * Returns the Artifact version.
     */
    public function getVersion(): string;

    /**
     * Returns the complete Artifact manifest.
     */
    public function getManifest(): ArtifactManifest;

    /**
     * Returns the Artifact creation timestamp.
     */
    public function getCreatedAt(): DateTimeImmutable;

    /**
     * Returns the last modification timestamp.
     */
    public function getUpdatedAt(): DateTimeImmutable;

    /**
     * Updates the modification timestamp.
     */
    public function touch(): void;

    /**
     * Returns true when the Artifact can be manufactured.
     */
    public function isManufacturable(): bool;

    /**
     * Returns true when the Artifact can be verified.
     */
    public function isVerifiable(): bool;

    /**
     * Returns true when the Artifact can be certified.
     */
    public function isCertifiable(): bool;

    /**
     * Returns the Artifact as an array.
     *
     * Intended for persistence, reporting and serialization.
     *
     * @return array<string,mixed>
     */
    public function toArray(): array;
}