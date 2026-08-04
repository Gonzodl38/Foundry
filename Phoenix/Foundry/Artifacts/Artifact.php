<?php

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/Foundry/Artifacts/Artifact.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Foundry\Artifacts;

use Phoenix\Foundry\Exceptions\InvalidArtifactTransitionException;

final class Artifact
{
    /**
     * @var ArtifactStatus[]
     */
    private array $history = [];

    public function __construct(
        private readonly ArtifactId $id,
        private readonly ArtifactType $type,
        private ArtifactStatus $status = ArtifactStatus::DRAFT,
    ) {
        $this->history[] = $status;
    }

    public function id(): ArtifactId
    {
        return $this->id;
    }

    public function type(): ArtifactType
    {
        return $this->type;
    }

    public function status(): ArtifactStatus
    {
        return $this->status;
    }

    /**
     * @return ArtifactStatus[]
     */
    public function history(): array
    {
        return $this->history;
    }

    public function transitionTo(ArtifactStatus $next): void
    {
        if (! $this->status->canTransitionTo($next)) {
            throw new InvalidArtifactTransitionException(
                sprintf(
                    'Cannot transition artifact from [%s] to [%s].',
                    $this->status->label(),
                    $next->label()
                )
            );
        }

        $this->status = $next;

        $this->history[] = $next;
    }

    public function plan(): void
    {
        $this->transitionTo(ArtifactStatus::PLANNED);
    }

    public function forge(): void
    {
        $this->transitionTo(ArtifactStatus::FORGED);
    }

    public function verify(): void
    {
        $this->transitionTo(ArtifactStatus::VERIFIED);
    }

    public function certify(): void
    {
        $this->transitionTo(ArtifactStatus::CERTIFIED);
    }

    public function release(): void
    {
        $this->transitionTo(ArtifactStatus::RELEASED);
    }

    public function archive(): void
    {
        $this->transitionTo(ArtifactStatus::ARCHIVED);
    }
}