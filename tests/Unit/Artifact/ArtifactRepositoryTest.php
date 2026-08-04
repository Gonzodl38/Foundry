<?php

// File: C:\Projects\tests\Unit\Artifact\ArtifactRepositoryTest.php

declare(strict_types=1);

namespace Phoenix\Tests\Unit\Artifact;

use Phoenix\Tests\TestCase;
use Phoenix\Foundry\Artifacts\Artifact;
use Phoenix\Foundry\Artifacts\ArtifactId;
use Phoenix\Foundry\Artifacts\ArtifactRepository;
use Phoenix\Foundry\Artifacts\ArtifactStatus;
use Phoenix\Foundry\Artifacts\ArtifactType;

final class ArtifactRepositoryTest extends TestCase
{
    private function createArtifact(): Artifact
    {
        return new Artifact(
            ArtifactId::generate(),
            ArtifactType::WORK_ORDER,
            ArtifactStatus::DRAFT
        );
    }

    public function testRepositoryStartsEmpty(): void
    {
        $repository = new ArtifactRepository();

        $this->assertSame(0, $repository->count());
        $this->assertSame([], $repository->all());
    }

    public function testRepositoryCanSaveArtifact(): void
    {
        $repository = new ArtifactRepository();
        $artifact = $this->createArtifact();

        $repository->save($artifact);

        $this->assertSame(1, $repository->count());
        $this->assertTrue($repository->exists($artifact->id()));
    }

    public function testRepositoryCanFindSavedArtifact(): void
    {
        $repository = new ArtifactRepository();
        $artifact = $this->createArtifact();

        $repository->save($artifact);

        $loaded = $repository->find($artifact->id());

        $this->assertNotNull($loaded);
        $this->assertSame($artifact, $loaded);
    }

    public function testRepositoryRemovesArtifact(): void
    {
        $repository = new ArtifactRepository();
        $artifact = $this->createArtifact();

        $repository->save($artifact);
        $repository->remove($artifact->id());

        $this->assertSame(0, $repository->count());
        $this->assertFalse($repository->exists($artifact->id()));
    }

    public function testRepositoryCanBeCleared(): void
    {
        $repository = new ArtifactRepository();

        $repository->save($this->createArtifact());
        $repository->save($this->createArtifact());

        $repository->clear();

        $this->assertSame(0, $repository->count());
        $this->assertSame([], $repository->all());
    }

    public function testFindReturnsNullWhenArtifactDoesNotExist(): void
    {
        $repository = new ArtifactRepository();

        $this->assertNull(
            $repository->find(
                ArtifactId::generate()
            )
        );
    }
}