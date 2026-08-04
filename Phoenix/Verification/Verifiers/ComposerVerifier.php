<?php

/**
 * File: Phoenix/Verification/Verifiers/ComposerVerifier.php
 *
 * Asset ID: PF-0007
 */

declare(strict_types=1);

namespace Phoenix\Verification\Verifiers;

use Phoenix\Verification\Contracts\VerifierInterface;
use Phoenix\Verification\Results\VerificationResult;

/**
 * Verifies that the repository contains a readable composer.json file.
 */
final class ComposerVerifier implements VerifierInterface
{
    public function __construct(
        private readonly string $repositoryRoot
    ) {
    }

    public function name(): string
    {
        return 'Composer';
    }

    public function verify(): VerificationResult
    {
        $start = microtime(true);

        $composerFile = $this->repositoryRoot . DIRECTORY_SEPARATOR . 'composer.json';

        $exists = is_file($composerFile) && is_readable($composerFile);

        $duration = (int) ((microtime(true) - $start) * 1000);

        return new VerificationResult(
            name: $this->name(),
            successful: $exists,
            message: $exists
                ? 'composer.json found.'
                : 'composer.json not found.',
            duration: $duration,
        );
    }
}