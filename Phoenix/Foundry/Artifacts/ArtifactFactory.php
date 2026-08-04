<?php

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/Foundry/Artifacts/ArtifactFactory.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Foundry\Artifacts;

final class ArtifactFactory
{
    private function __construct()
    {
        // Static factory.
    }

    public static function create(
        ArtifactType $type
    ): Artifact {

        return new Artifact(
            ArtifactId::generate(),
            $type,
            ArtifactStatus::DRAFT
        );
    }
}