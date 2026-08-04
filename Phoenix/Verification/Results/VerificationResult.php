<?php

/**
 * File: Phoenix/Verification/Results/VerificationResult.php
 *
 * Asset ID: PF-0002
 */

declare(strict_types=1);

namespace Phoenix\Verification\Results;

/**
 * Represents the immutable result produced by a single verifier.
 */
final class VerificationResult
{
    public function __construct(
        private readonly string $name,
        private readonly bool $successful,
        private readonly string $message,
        private readonly int $duration
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function successful(): bool
    {
        return $this->successful;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function duration(): int
    {
        return $this->duration;
    }
}