<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Engines\Verification\Exceptions\VerificationException.php
 *
 * Artifact ID: EXCEPTION-000002
 * File ID: FILE-000015
 *
 * Title:
 * Verification Exception
 *
 * Description:
 * Base exception for every error raised by the Verification Engine.
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

namespace Phoenix\Engines\Verification\Exceptions;

use RuntimeException;
use Throwable;

class VerificationException extends RuntimeException
{
    /**
     * Creates a VerificationException.
     */
    public function __construct(
        string $message = 'Verification operation failed.',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Creates an exception for a verification failure.
     */
    public static function verificationFailed(
        string $artifactId,
        string $reason
    ): self {
        return new self(
            sprintf(
                'Verification failed for Artifact "%s". %s',
                $artifactId,
                $reason
            )
        );
    }

    /**
     * Creates an exception for an invalid Artifact.
     */
    public static function invalidArtifact(
        string $artifactId
    ): self {
        return new self(
            sprintf(
                'Artifact "%s" is not valid.',
                $artifactId
            )
        );
    }

    /**
     * Creates an exception for an unsupported Artifact.
     */
    public static function unsupportedArtifact(
        string $artifactClass
    ): self {
        return new self(
            sprintf(
                'Artifact "%s" is not supported by the Verification Engine.',
                $artifactClass
            )
        );
    }

    /**
     * Creates an exception for an inconsistent Artifact.
     */
    public static function inconsistentArtifact(
        string $artifactId
    ): self {
        return new self(
            sprintf(
                'Artifact "%s" failed consistency verification.',
                $artifactId
            )
        );
    }
}