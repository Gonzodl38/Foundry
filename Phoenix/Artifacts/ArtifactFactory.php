<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path:
 * C:\Projects\Phoenix\Artifacts\ArtifactFactory.php
 *
 * Artifact ID:
 * ARTIFACT-000007
 *
 * File ID:
 * FILE-000007
 *
 * Title:
 * Artifact Factory
 *
 * Description:
 * Manufactures governed Artifact instances.
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

use InvalidArgumentException;
use Phoenix\Artifacts\DTO\ArtifactManifest;

final class ArtifactFactory
{
    /**
     * Creates a new Artifact instance.
     *
     * @template T of Artifact
     *
     * @param class-string<T> $artifactClass
     *
     * @return T
     */
    public function create(
        string $artifactClass,
        ArtifactManifest $manifest
    ): Artifact {
        if (!class_exists($artifactClass)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Artifact class "%s" does not exist.',
                    $artifactClass
                )
            );
        }

        if (!is_subclass_of($artifactClass, Artifact::class)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid Artifact.',
                    $artifactClass
                )
            );
        }

        /** @var T $artifact */
        $artifact = new $artifactClass($manifest);

        return $artifact;
    }

    /**
     * Determines whether the supplied class can be manufactured.
     */
    public function supports(string $artifactClass): bool
    {
        return class_exists($artifactClass)
            && is_subclass_of($artifactClass, Artifact::class);
    }

    /**
     * Manufactures an Artifact or throws an exception.
     *
     * @template T of Artifact
     *
     * @param class-string<T> $artifactClass
     *
     * @return T
     */
    public function manufacture(
        string $artifactClass,
        ArtifactManifest $manifest
    ): Artifact {
        return $this->create(
            artifactClass: $artifactClass,
            manifest: $manifest
        );
    }
}