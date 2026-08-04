<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path:
 * C:\Projects\Phoenix\Artifacts\ArtifactRegistry.php
 *
 * Artifact ID:
 * ARTIFACT-000008
 *
 * File ID:
 * FILE-000008
 *
 * Title:
 * Artifact Registry
 *
 * Description:
 * In-memory registry responsible for registering and resolving governed
 * Artifacts during the bootstrap phase of PEOS.
 *
 * Work Order:
 * WO-000004
 *
 * Specification:
 * SPEC-000004
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

use InvalidArgumentException;
use RuntimeException;

final class ArtifactRegistry
{
    /**
     * @var array<string,Artifact>
     */
    private array $artifacts = [];

    /**
     * Registers an Artifact.
     *
     * @throws RuntimeException
     */
    public function register(Artifact $artifact): void
    {
        $id = (string) $artifact->getId();

        if ($this->has($artifact->getId())) {
            throw new RuntimeException(
                sprintf(
                    'Artifact "%s" is already registered.',
                    $id
                )
            );
        }

        $this->artifacts[$id] = $artifact;
    }

    /**
     * Removes an Artifact from the Registry.
     */
    public function unregister(ArtifactId $id): void
    {
        unset($this->artifacts[(string) $id]);
    }

    /**
     * Determines whether an Artifact exists.
     */
    public function has(ArtifactId $id): bool
    {
        return array_key_exists(
            (string) $id,
            $this->artifacts
        );
    }

    /**
     * Resolves an Artifact by its identifier.
     *
     * @throws InvalidArgumentException
     */
    public function resolve(ArtifactId $id): Artifact
    {
        if (!$this->has($id)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Artifact "%s" is not registered.',
                    (string) $id
                )
            );
        }

        return $this->artifacts[(string) $id];
    }

    /**
     * Returns every registered Artifact.
     *
     * @return array<string,Artifact>
     */
    public function all(): array
    {
        return $this->artifacts;
    }

    /**
     * Returns the number of registered Artifacts.
     */
    public function count(): int
    {
        return count($this->artifacts);
    }

    /**
     * Removes every registered Artifact.
     */
    public function clear(): void
    {
        $this->artifacts = [];
    }

    /**
     * Indicates whether the Registry is empty.
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }
}