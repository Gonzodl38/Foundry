<?php

/**
 * File: Phoenix/Tests/Verification/VerificationEngineTest.php
 *
 * Asset ID: PF-0009
 */

declare(strict_types=1);

namespace Phoenix\Tests\Verification;

use PHPUnit\Framework\TestCase;
use Phoenix\Verification\Contracts\VerifierInterface;
use Phoenix\Verification\Results\VerificationReport;
use Phoenix\Verification\Results\VerificationResult;
use Phoenix\Verification\VerificationEngine;

/**
 * Verifies the behavior of the VerificationEngine.
 */
final class VerificationEngineTest extends TestCase
{
    public function test_executes_all_verifiers_and_returns_a_report(): void
    {
        // Arrange
        $verifiers = [
            new class implements VerifierInterface {
                public function name(): string
                {
                    return 'Verifier A';
                }

                public function verify(): VerificationResult
                {
                    return new VerificationResult(
                        name: $this->name(),
                        successful: true,
                        message: 'OK',
                        duration: 1,
                    );
                }
            },
            new class implements VerifierInterface {
                public function name(): string
                {
                    return 'Verifier B';
                }

                public function verify(): VerificationResult
                {
                    return new VerificationResult(
                        name: $this->name(),
                        successful: true,
                        message: 'OK',
                        duration: 1,
                    );
                }
            },
        ];

        $engine = new VerificationEngine($verifiers);

        // Act
        $report = $engine->execute();

        // Assert
        self::assertInstanceOf(VerificationReport::class, $report);
        self::assertCount(2, $report->results());
        self::assertSame(2, $report->total());
        self::assertSame(2, $report->passed());
        self::assertSame(0, $report->failed());
        self::assertTrue($report->successful());
    }

    public function test_returns_an_empty_report_when_no_verifiers_are_registered(): void
    {
        // Arrange
        $engine = new VerificationEngine([]);

        // Act
        $report = $engine->execute();

        // Assert
        self::assertSame(0, $report->total());
        self::assertSame(0, $report->passed());
        self::assertSame(0, $report->failed());
        self::assertTrue($report->successful());
    }
}