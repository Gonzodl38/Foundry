<?php

/**
 * File: Phoenix/Tests/Verification/Verifiers/PhpVersionVerifierTest.php
 *
 * Asset ID: PF-0006
 */

declare(strict_types=1);

namespace Phoenix\Tests\Verification\Verifiers;

use PHPUnit\Framework\TestCase;
use Phoenix\Verification\Contracts\VerifierInterface;
use Phoenix\Verification\Results\VerificationResult;
use Phoenix\Verification\Verifiers\PhpVersionVerifier;

/**
 * Verifies the behavior of the PhpVersionVerifier.
 */
final class PhpVersionVerifierTest extends TestCase
{
    public function test_implements_verifier_interface(): void
    {
        // Arrange
        $verifier = new PhpVersionVerifier('8.2.0');

        // Act / Assert
        self::assertInstanceOf(VerifierInterface::class, $verifier);
    }

    public function test_returns_expected_name(): void
    {
        // Arrange
        $verifier = new PhpVersionVerifier('8.2.0');

        // Act
        $name = $verifier->name();

        // Assert
        self::assertSame('PHP Version', $name);
    }

    public function test_returns_success_when_requirement_is_satisfied(): void
    {
        // Arrange
        $verifier = new PhpVersionVerifier('8.2.0');

        // Act
        $result = $verifier->verify();

        // Assert
        self::assertInstanceOf(VerificationResult::class, $result);
        self::assertTrue($result->successful());
        self::assertSame('PHP Version', $result->name());
        self::assertGreaterThanOrEqual(0, $result->duration());
        self::assertNotSame('', trim($result->message()));
    }

    public function test_returns_failure_when_requirement_is_not_satisfied(): void
    {
        // Arrange
        $futureVersion = PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION . '.' . (PHP_RELEASE_VERSION + 1);

        $verifier = new PhpVersionVerifier($futureVersion);

        // Act
        $result = $verifier->verify();

        // Assert
        self::assertInstanceOf(VerificationResult::class, $result);
        self::assertFalse($result->successful());
        self::assertSame('PHP Version', $result->name());
        self::assertGreaterThanOrEqual(0, $result->duration());
        self::assertNotSame('', trim($result->message()));
    }
}