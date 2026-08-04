<?php

/**
 * File: Phoenix/Verification/Results/VerificationReport.php
 *
 * Asset ID: PF-0003
 */

declare(strict_types=1);

namespace Phoenix\Verification\Results;

/**
 * Represents the complete outcome of a verification session.
 */
final class VerificationReport
{
    /**
     * @param VerificationResult[] $results
     */
    public function __construct(
        private readonly array $results
    ) {
    }

    /**
     * @return VerificationResult[]
     */
    public function results(): array
    {
        return $this->results;
    }

    public function total(): int
    {
        return count($this->results);
    }

    public function passed(): int
    {
        return count(
            array_filter(
                $this->results,
                static fn (VerificationResult $result): bool => $result->successful()
            )
        );
    }

    public function failed(): int
    {
        return $this->total() - $this->passed();
    }

    public function successful(): bool
    {
        return $this->failed() === 0;
    }
}