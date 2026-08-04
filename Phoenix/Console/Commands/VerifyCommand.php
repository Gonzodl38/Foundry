<?php

/**
 * File: Phoenix/Console/Commands/VerifyCommand.php
 *
 * Asset ID: PF-0010
 */

declare(strict_types=1);

namespace Phoenix\Console\Commands;

use Phoenix\Verification\VerificationEngine;
use Phoenix\Verification\Verifiers\ComposerVerifier;
use Phoenix\Verification\Verifiers\PhpVersionVerifier;
use Phoenix\Verification\Verifiers\StructureVerifier;

final class VerifyCommand
{
    public function execute(string $repositoryRoot): int
    {
        $verifiers = [
            new PhpVersionVerifier(PHP_VERSION),
            new ComposerVerifier($repositoryRoot),
            new StructureVerifier($repositoryRoot),
        ];

        $engine = new VerificationEngine($verifiers);

        $report = $engine->execute();

        echo "Phoenix Foundry\n";
        echo "===============================\n";

        foreach ($report->results() as $result) {
            printf(
                "%-22s : %s\n",
                $result->name(),
                $result->successful() ? 'PASS' : 'FAIL'
            );
        }

        echo "\n";

        printf(
            "Repository Status : %s\n",
            $report->successful() ? 'HEALTHY' : 'UNHEALTHY'
        );

        return $report->successful() ? 0 : 1;
    }
}