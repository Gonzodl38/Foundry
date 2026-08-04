<?php

// File: C:\Projects\tests\Unit\Artifact\ArtifactFactoryTest.php

declare(strict_types=1);

namespace Phoenix\Tests\Unit\Artifact;

use Phoenix\Tests\TestCase;
use Phoenix\Foundry\Artifacts\Artifact;
use Phoenix\Foundry\Artifacts\ArtifactFactory;
use Phoenix\Foundry\Artifacts\ArtifactStatus;
use Phoenix\Foundry\Artifacts\ArtifactType;

final class ArtifactFactoryTest extends TestCase
{
    public function testFactoryCreatesArtifact(): void
    {
        $artifact = ArtifactFactory::create(
            ArtifactType::WORK_ORDER
        );

        $this->assertInstanceOf(
            Artifact::class,
            $artifact
        );
    }

    public function testFactoryCreatesArtifactWithRequestedType(): void
    {
        $artifact = ArtifactFactory::create(
            ArtifactType::WORK_ORDER
        );

        $this->assertSame(
            ArtifactType::WORK_ORDER,
            $artifact->type()
        );
    }

    public function testFactoryCreatesArtifactInDraftStatus(): void
    {
        $artifact = ArtifactFactory::create(
            ArtifactType::WORK_ORDER
        );

        $this->assertSame(
            ArtifactStatus::DRAFT,
            $artifact->status()
        );
    }

    public function testFactoryGeneratesArtifactId(): void
    {
        $artifact = ArtifactFactory::create(
            ArtifactType::WORK_ORDER
        );

        $this->assertNotNull(
            $artifact->id()
        );
    }

    public function testFactoryGeneratesUniqueIds(): void
    {
        $artifact1 = ArtifactFactory::create(
            ArtifactType::WORK_ORDER
        );

        $artifact2 = ArtifactFactory::create(
            ArtifactType::WORK_ORDER
        );

        $this->assertNotSame(
            $artifact1->id(),
            $artifact2->id()
        );
    }
}