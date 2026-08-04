<?php

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/Foundry/Artifacts/ArtifactStatus.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Foundry\Artifacts;

enum ArtifactStatus: string
{
    case DRAFT      = 'draft';

    case PLANNED    = 'planned';

    case FORGED     = 'forged';

    case VERIFIED   = 'verified';

    case CERTIFIED  = 'certified';

    case RELEASED   = 'released';

    case ARCHIVED   = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT     => 'Draft',
            self::PLANNED   => 'Planned',
            self::FORGED    => 'Forged',
            self::VERIFIED  => 'Verified',
            self::CERTIFIED => 'Certified',
            self::RELEASED  => 'Released',
            self::ARCHIVED  => 'Archived',
        };
    }

    public function canTransitionTo(self $next): bool
    {
        return match ($this) {

            self::DRAFT =>
                $next === self::PLANNED,

            self::PLANNED =>
                $next === self::FORGED,

            self::FORGED =>
                $next === self::VERIFIED,

            self::VERIFIED =>
                $next === self::CERTIFIED,

            self::CERTIFIED =>
                $next === self::RELEASED,

            self::RELEASED =>
                $next === self::ARCHIVED,

            self::ARCHIVED =>
                false,
        };
    }

    public function isFinal(): bool
    {
        return $this === self::ARCHIVED;
    }
}