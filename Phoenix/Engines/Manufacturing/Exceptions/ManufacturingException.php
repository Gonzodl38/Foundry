<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Engines\Manufacturing\Exceptions\ManufacturingException.php
 *
 * Artifact ID: EXCEPTION-000001
 * File ID: FILE-000010
 *
 * Title:
 * Manufacturing Exception
 *
 * Description:
 * Base exception for every error raised by the Manufacturing Engine.
 *
 * Work Order:
 * WO-000004
 *
 * Specification:
 * SPEC-000006
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

namespace Phoenix\Engines\Manufacturing\Exceptions;

use RuntimeException;
use Throwable;

class ManufacturingException extends RuntimeException
{
    /**
     * Creates a ManufacturingException.
     */
    public function __construct(
        string $message = 'Manufacturing operation failed.',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Creates an exception for an unsupported Artifact.
     */
    public static function unsupportedArtifact(string $artifactClass): self
    {
        return new self(
            sprintf(
                'Artifact "%s" is not supported by the Manufacturing Engine.',
                $artifactClass
            )
        );
    }

    /**
     * Creates an exception for a manufacturing failure.
     */
    public static function manufacturingFailed(
        string $artifactClass,
        string $reason
    ): self {
        return new self(
            sprintf(
                'Unable to manufacture "%s". %s',
                $artifactClass,
                $reason
            )
        );
    }

    /**
     * Creates an exception for a verification failure.
     */
    public static function verificationFailed(string $artifactId): self
    {
        return new self(
            sprintf(
                'Verification failed for Artifact "%s".',
                $artifactId
            )
        );
    }

    /**
     * Creates an exception for a certification failure.
     */
    public static function certificationFailed(string $artifactId): self
    {
        return new self(
            sprintf(
                'Certification failed for Artifact "%s".',
                $artifactId
            )
        );
    }

    /**
     * Creates an exception for a registration failure.
     */
    public static function registrationFailed(string $artifactId): self
    {
        return new self(
            sprintf(
                'Registration failed for Artifact "%s".',
                $artifactId
            )
        );
    }
}