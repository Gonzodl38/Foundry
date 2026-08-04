<?php

/**
 * File: Phoenix/Verification/Verifiers/StructureVerifier.php
 *
 * Asset ID: PF-0008
 */

declare(strict_types=1);

namespace Phoenix\Verification\Verifiers;

use Phoenix\Verification\Contracts\VerifierInterface;
use Phoenix\Verification\Results\VerificationResult;

/**
 * Verifies that the repository contains the required directory structure.
 */
final class StructureVerifier implements VerifierInterface
{
    /**
     * @param string[] $requiredDirectories
     */
    public function __construct(
        private readonly string $repositoryRoot,
        private readonly array $requiredDirectories = [
            'Phoenix',
            'Phoenix/Verification',
            'Phoenix/Tests',
            'tools',
        ]
    ) {
    }

    public function name(): string
    {
        return 'Repository Structure';
    }

    public function verify(): VerificationResult
    {
        $start = microtime(true);

        $missing = [];

        foreach ($this->requiredDirectories as $directory) {
            $path = $this->repositoryRoot
                . DIRECTORY_SEPARATOR
                . str_replace('/', DIRECTORY_SEPARATOR, $directory);

            if (!is_dir($path)) {
                $missing[] = $directory;
            }
        }

        $duration = (int) ((microtime(true) - $start) * 1000);

        if ($missing === []) {
            return new VerificationResult(
                name: $this->name(),
                successful: true,
                message: 'Required repository structure verified.',
                duration: $duration,
            );
        }

        return new VerificationResult(
            name: $this->name(),
            successful: false,
            message: 'Missing required directories: ' . implode(', ', $missing),
            duration: $duration,
        );
    }
}