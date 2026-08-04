<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Engines\Verification\VerificationEngine.php
 *
 * Artifact ID: ENGINE-000002
 * File ID: FILE-000016
 *
 * Title:
 * Verification Engine
 *
 * Description:
 * Orchestrates the complete verification lifecycle of governed Artifacts.
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

namespace Phoenix\Engines\Verification;

use Throwable;
use Phoenix\Artifacts\Artifact;
use Phoenix\Engines\Verification\Contracts\VerificationEngineContract;
use Phoenix\Engines\Verification\DTO\VerificationResult;
use Phoenix\Engines\Verification\Exceptions\VerificationException;

final class VerificationEngine implements VerificationEngineContract
{
    private ?VerificationResult $lastResult = null;

    /**
     * {@inheritDoc}
     */
    public function verify(
        Artifact $artifact
    ): VerificationResult {
        $started = microtime(true);

        try {
            if (!$this->isValid($artifact)) {
                throw VerificationException::invalidArtifact(
                    (string) $artifact->getId()
                );
            }

            $this->lastResult = VerificationResult::success(
                artifact: $artifact,
                messages: [
                    'Verification completed successfully.',
                ],
                executionTime: microtime(true) - $started
            );

            return $this->lastResult;
        } catch (Throwable $exception) {
            $this->lastResult = VerificationResult::failure(
                messages: [$exception->getMessage()],
                executionTime: microtime(true) - $started
            );

            return $this->lastResult;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function isValid(
        Artifact $artifact
    ): bool {
        return
            $artifact->getId() !== null
            && $artifact->getManifest() !== null
            && $artifact->getType() !== null
            && $artifact->getStatus() !== null;
    }

    /**
     * {@inheritDoc}
     */
    public function lastResult(): ?VerificationResult
    {
        return $this->lastResult;
    }
}