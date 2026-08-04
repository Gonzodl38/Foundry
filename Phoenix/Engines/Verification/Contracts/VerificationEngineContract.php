<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Engines\Verification\Contracts\VerificationEngineContract.php
 *
 * Artifact ID: CONTRACT-000003
 * File ID: FILE-000013
 *
 * Title:
 * Verification Engine Contract
 *
 * Description:
 * Defines the public contract implemented by every Verification Engine.
 *
 * Work Order:
 * WO-000005
 *
 * Specification:
 * SPEC-000007
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

namespace Phoenix\Engines\Verification\Contracts;

use Phoenix\Artifacts\Artifact;
use Phoenix\Engines\Verification\DTO\VerificationResult;

interface VerificationEngineContract
{
    /**
     * Verifies a governed Artifact.
     */
    public function verify(
        Artifact $artifact
    ): VerificationResult;

    /**
     * Determines whether the Artifact is valid.
     */
    public function isValid(
        Artifact $artifact
    ): bool;

    /**
     * Returns the last verification result.
     */
    public function lastResult(): ?VerificationResult;
}