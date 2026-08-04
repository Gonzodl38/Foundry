<?php

/**
 * File: Phoenix/Verification/VerificationEngine.php
 *
 * Asset ID: PF-0004
 */

declare(strict_types=1);

namespace Phoenix\Verification;

use Phoenix\Verification\Contracts\VerifierInterface;
use Phoenix\Verification\Results\VerificationReport;
use Phoenix\Verification\Results\VerificationResult;

/**
 * Coordinates repository verification by executing a collection of verifiers.
 */
final class VerificationEngine
{
    /**
     * @param VerifierInterface[] $verifiers
     */
    public function __construct(
        private readonly array $verifiers
    ) {
    }

    public function execute(): VerificationReport
    {
        $results = [];

        foreach ($this->verifiers as $verifier) {
            $results[] = $verifier->verify();
        }

        return new VerificationReport($results);
    }
}