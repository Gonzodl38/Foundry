<?php

/**
 * File: Phoenix/Verification/Contracts/VerifierInterface.php
 *
 * Asset ID: PF-0001
 */

declare(strict_types=1);

namespace Phoenix\Verification\Contracts;

use Phoenix\Verification\Results\VerificationResult;

/**
 * Defines the contract implemented by every verification component.
 *
 * A verifier is responsible for evaluating exactly one concern and
 * returning an objective verification result.
 */
interface VerifierInterface
{
    /**
     * Returns the human-readable name of the verifier.
     */
    public function name(): string;

    /**
     * Executes the verification.
     */
    public function verify(): VerificationResult;
}