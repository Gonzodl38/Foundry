<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Engines\Manufacturing\DTO\ManufacturingResult.php
 *
 * Artifact ID: DTO-000001
 * File ID: FILE-000011
 *
 * Title:
 * Manufacturing Result
 *
 * Description:
 * Immutable Data Transfer Object representing the outcome of a
 * manufacturing operation.
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

namespace Phoenix\Engines\Manufacturing\DTO;

use JsonSerializable;
use Phoenix\Artifacts\Artifact;

final readonly class ManufacturingResult implements JsonSerializable
{
    /**
     * @param array<string> $messages
     * @param array<string,mixed> $context
     */
    public function __construct(
        public bool $success,
        public ?Artifact $artifact = null,
        public array $messages = [],
        public array $context = [],
        public float $executionTime = 0.0
    ) {
    }

    /**
     * Creates a successful result.
     */
    public static function success(
        Artifact $artifact,
        array $messages = [],
        array $context = [],
        float $executionTime = 0.0
    ): self {
        return new self(
            success: true,
            artifact: $artifact,
            messages: $messages,
            context: $context,
            executionTime: $executionTime
        );
    }

    /**
     * Creates a failed result.
     *
     * @param array<string> $messages
     * @param array<string,mixed> $context
     */
    public static function failure(
        array $messages,
        array $context = [],
        float $executionTime = 0.0
    ): self {
        return new self(
            success: false,
            artifact: null,
            messages: $messages,
            context: $context,
            executionTime: $executionTime
        );
    }

    /**
     * Indicates whether the operation succeeded.
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Indicates whether the operation failed.
     */
    public function isFailure(): bool
    {
        return !$this->success;
    }

    /**
     * Returns the result as an array.
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'artifact' => $this->artifact?->toArray(),
            'messages' => $this->messages,
            'context' => $this->context,
            'executionTime' => $this->executionTime,
        ];
    }

    /**
     * Returns the result as JSON.
     *
     * @return array<string,mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
} 