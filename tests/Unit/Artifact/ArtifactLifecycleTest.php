<?php

// File: C:\Projects\tests\Unit\Artifact\ArtifactLifecycleTest.php

declare(strict_types=1);

namespace Phoenix\Tests\Unit\Artifact;

use Phoenix\Tests\TestCase;
use Phoenix\Foundry\Artifacts\Artifact;
use Phoenix\Foundry\Artifacts\ArtifactId;
use Phoenix\Foundry\Artifacts\ArtifactStatus;
use Phoenix\Foundry\Artifacts\ArtifactType;
use Phoenix\Foundry\Exceptions\InvalidArtifactTransitionException;

final class ArtifactLifecycleTest extends TestCase
{
    private function createArtifact(): Artifact
    {
        return new Artifact(
            ArtifactId::generate(),
            ArtifactType::WORK_ORDER
        );
    }

    public function testArtifactStartsInDraft(): void
    {
        $artifact = $this->createArtifact();

        $this->assertSame(
            ArtifactStatus::DRAFT,
            $artifact->status()
        );
    }

    public function testArtifactCanCompleteLifecycle(): void
    {
        $artifact = $this->createArtifact();

        $artifact->plan();
        $artifact->forge();
        $artifact->verify();
        $artifact->certify();
        $artifact->release();
        $artifact->archive();

        $this->assertSame(
            ArtifactStatus::ARCHIVED,
            $artifact->status()
        );
    }

    public function testLifecycleHistoryContainsEveryState(): void
    {
        $artifact = $this->createArtifact();

        $artifact->plan();
        $artifact->forge();
        $artifact->verify();
        $artifact->certify();
        $artifact->release();
        $artifact->archive();

        $this->assertSame(
            [
                ArtifactStatus::DRAFT,
                ArtifactStatus::PLANNED,
                ArtifactStatus::FORGED,
                ArtifactStatus::VERIFIED,
                ArtifactStatus::CERTIFIED,
                ArtifactStatus::RELEASED,
                ArtifactStatus::ARCHIVED,
            ],
            $artifact->history()
        );
    }

    public function testInvalidTransitionThrowsException(): void
    {
        $this->expectException(
            InvalidArtifactTransitionException::class
        );

        $artifact = $this->createArtifact();

        $artifact->release();
    }
}