<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Verification\DTO\ValidationResult.php
 *
 * Artifact ID: DTO-000003
 * File ID: FILE-000020
 *
 * Title:
 * Validation Result
 *
 * Description:
 * Immutable result produced by a single validator.
 *
 * Work Order:
 * WO-000006
 *
 * Specification:
 * SPEC-000008
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

namespace Phoenix\Verification\DTO;

use JsonSerializable;

final readonly class ValidationResult implements JsonSerializable
{
    /**
     * @param array<string> $messages
     * @param array<string,mixed> $context
     */
    public function __construct(
        public string $validator,
        public bool $passed,
        public string $classification,
        public array $messages = [],
        public array $context = [],
        public float $executionTime = 0.0
    ) {
    }

    /**
     * Indicates whether the validation passed.
     */
    public function isPassed(): bool
    {
        return $this->passed;
    }

    /**
     * Indicates whether the validation failed.
     */
    public function isFailed(): bool
    {
        return !$this->passed;
    }

    /**
     * Returns the result as an array.
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'validator'      => $this->validator,
            'passed'         => $this->passed,
            'classification' => $this->classification,
            'messages'       => $this->messages,
            'context'        => $this->context,
            'executionTime'  => $this->executionTime,
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
