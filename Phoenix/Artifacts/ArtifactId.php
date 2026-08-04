<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path:
 * C:\Projects\Phoenix\Artifacts\ArtifactId.php
 *
 * Artifact ID:
 * ARTIFACT-000002
 *
 * File ID:
 * FILE-000002
 *
 * Title:
 * Artifact Identifier
 *
 * Description:
 * Immutable Value Object representing the unique identifier of every
 * governed Artifact managed by PEOS.
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

namespace Phoenix\Artifacts;

use InvalidArgumentException;
use JsonSerializable;
use Stringable;

final class ArtifactId implements Stringable, JsonSerializable
{
    /**
     * Canonical Artifact ID pattern.
     *
     * Examples:
     * SPEC-000001
     * ADR-000015
     * WO-000004
     * TOOL-000021
     */
    private const PATTERN = '/^[A-Z][A-Z0-9_]*-\d{6}$/';

    /**
     * Creates a new immutable ArtifactId.
     */
    public function __construct(
        private readonly string $value
    ) {
        $this->assertValid($value);
    }

    /**
     * Creates an ArtifactId from its string representation.
     */
    public static function fromString(string $value): self
    {
        return new self(trim($value));
    }

    /**
     * Generates a new ArtifactId.
     */
    public static function generate(string $prefix, int $sequence): self
    {
        $prefix = strtoupper(trim($prefix));

        return new self(
            sprintf('%s-%06d', $prefix, $sequence)
        );
    }

    /**
     * Returns the prefix.
     *
     * Example:
     * SPEC
     */
    public function prefix(): string
    {
        return explode('-', $this->value)[0];
    }

    /**
     * Returns the numeric sequence.
     */
    public function sequence(): int
    {
        [, $sequence] = explode('-', $this->value);

        return (int) $sequence;
    }

    /**
     * Determines whether two ArtifactIds are equal.
     */
    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    /**
     * Returns the identifier as string.
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * String representation.
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * JSON serialization.
     */
    public function jsonSerialize(): string
    {
        return $this->value;
    }

    /**
     * Validates the ArtifactId.
     */
    private function assertValid(string $value): void
    {
        if (!preg_match(self::PATTERN, $value)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid Artifact ID "%s". Expected format PREFIX-000001.',
                    $value
                )
            );
        }
    }
}