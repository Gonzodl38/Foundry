<?php

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/Foundry/Artifacts/ArtifactRepository.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Foundry\Artifacts;

final class ArtifactRepository
{
    /**
     * @var array<string, Artifact>
     */
    private array $artifacts = [];

    public function save(Artifact $artifact): void
    {
        $this->artifacts[(string) $artifact->id()] = $artifact;
    }

    public function find(ArtifactId $id): ?Artifact
    {
        return $this->artifacts[(string) $id] ?? null;
    }

    /**
     * @return Artifact[]
     */
    public function all(): array
    {
        return array_values($this->artifacts);
    }

    public function remove(ArtifactId $id): void
    {
        unset($this->artifacts[(string) $id]);
    }

    public function count(): int
    {
        return count($this->artifacts);
    }

    public function exists(ArtifactId $id): bool
    {
        return isset($this->artifacts[(string) $id]);
    }

    public function clear(): void
    {
        $this->artifacts = [];
    }
}