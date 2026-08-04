<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path:
 * C:\Projects\Phoenix\Artifacts\Enums\ArtifactStatus.php
 *
 * Artifact ID:
 * ARTIFACT-000004
 *
 * File ID:
 * FILE-000004
 *
 * Title:
 * Artifact Status Enumeration
 *
 * Description:
 * Defines the canonical lifecycle states of every governed Artifact
 * managed by the Phoenix Engineering Operating System.
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

namespace Phoenix\Artifacts\Enums;

enum ArtifactStatus: string
{
    case DRAFT = 'DRAFT';

    case IN_REVIEW = 'IN_REVIEW';

    case APPROVED = 'APPROVED';

    case MANUFACTURED = 'MANUFACTURED';

    case VERIFIED = 'VERIFIED';

    case CERTIFIED = 'CERTIFIED';

    case RELEASED = 'RELEASED';

    case SUPERSEDED = 'SUPERSEDED';

    case ARCHIVED = 'ARCHIVED';

    /**
     * Returns a human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::DRAFT        => 'Draft',
            self::IN_REVIEW    => 'In Review',
            self::APPROVED     => 'Approved',
            self::MANUFACTURED => 'Manufactured',
            self::VERIFIED     => 'Verified',
            self::CERTIFIED    => 'Certified',
            self::RELEASED     => 'Released',
            self::SUPERSEDED   => 'Superseded',
            self::ARCHIVED     => 'Archived',
        };
    }

    /**
     * Indicates whether the Artifact is editable.
     */
    public function isEditable(): bool
    {
        return match ($this) {
            self::DRAFT,
            self::IN_REVIEW => true,

            default => false,
        };
    }

    /**
     * Indicates whether the Artifact can be manufactured.
     */
    public function canManufacture(): bool
    {
        return $this === self::APPROVED;
    }

    /**
     * Indicates whether the Artifact can be verified.
     */
    public function canVerify(): bool
    {
        return $this === self::MANUFACTURED;
    }

    /**
     * Indicates whether the Artifact can be certified.
     */
    public function canCertify(): bool
    {
        return $this === self::VERIFIED;
    }

    /**
     * Indicates whether the Artifact is immutable.
     */
    public function isImmutable(): bool
    {
        return match ($this) {
            self::CERTIFIED,
            self::RELEASED,
            self::SUPERSEDED,
            self::ARCHIVED => true,

            default => false,
        };
    }

    /**
     * Indicates whether the Artifact lifecycle is complete.
     */
    public function isTerminal(): bool
    {
        return match ($this) {
            self::SUPERSEDED,
            self::ARCHIVED => true,

            default => false,
        };
    }

    /**
     * Returns the next valid lifecycle state.
     *
     * Returns null when no further transition exists.
     */
    public function next(): ?self
    {
        return match ($this) {
            self::DRAFT        => self::IN_REVIEW,
            self::IN_REVIEW    => self::APPROVED,
            self::APPROVED     => self::MANUFACTURED,
            self::MANUFACTURED => self::VERIFIED,
            self::VERIFIED     => self::CERTIFIED,
            self::CERTIFIED    => self::RELEASED,
            self::RELEASED     => self::SUPERSEDED,
            self::SUPERSEDED   => self::ARCHIVED,
            self::ARCHIVED     => null,
        };
    }

    /**
     * Returns all lifecycle states.
     *
     * @return list<self>
     */
    public static function lifecycle(): array
    {
        return self::cases();
    }
}