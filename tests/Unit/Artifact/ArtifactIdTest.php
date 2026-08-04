<?php
// File: C:\Projects\tests\Unit\Artifact\ArtifactIdTest.php
declare(strict_types=1);

namespace Phoenix\Tests\Unit\Artifact;

use Phoenix\Tests\TestCase;
use Phoenix\Foundry\Artifacts\ArtifactId;

final class ArtifactIdTest extends TestCase
{
    public function testGeneratedIdsAreUnique(): void
    {
        $id1 = ArtifactId::generate();
        $id2 = ArtifactId::generate();

        $this->assertNotSame($id1, $id2);
    }

    public function testGeneratedIdIsNotEmpty(): void
    {
        $this->assertNotEmpty(
            ArtifactId::generate()
        );
    }

    public function testGenerateReturnsArtifactId(): void
    {
        $id = ArtifactId::generate();

        $this->assertInstanceOf(
            ArtifactId::class,
            $id
        );
    }
}