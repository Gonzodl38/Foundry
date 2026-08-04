<?php

// File: C:\Projects\tests\Unit\Artifact\ArtifactStatusTest.php

declare(strict_types=1);

namespace Phoenix\Tests\Unit\Artifact;

use Phoenix\Tests\TestCase;
use Phoenix\Foundry\Artifacts\ArtifactStatus;

final class ArtifactStatusTest extends TestCase
{
    public function testDraftCanTransitionToPlanned(): void
    {
        $this->assertTrue(
            ArtifactStatus::DRAFT->canTransitionTo(
                ArtifactStatus::PLANNED
            )
        );
    }

    public function testDraftCannotTransitionToReleased(): void
    {
        $this->assertFalse(
            ArtifactStatus::DRAFT->canTransitionTo(
                ArtifactStatus::RELEASED
            )
        );
    }

    public function testArchivedIsFinal(): void
    {
        $this->assertTrue(
            ArtifactStatus::ARCHIVED->isFinal()
        );
    }
    public function testReleasedIsNotFinal(): void
    {
        $this->assertFalse(
            ArtifactStatus::RELEASED->isFinal()
        );
    }
}