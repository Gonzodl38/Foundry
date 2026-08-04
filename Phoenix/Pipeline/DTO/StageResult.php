<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Pipeline\DTO\StageResult.php
 *
 * Artifact ID: DTO-000004
 * File ID: FILE-000023
 *
 * Title:
 * Stage Result
 *
 * Description:
 * Immutable result produced by a single pipeline stage.
 *
 * Work Order:
 * WO-000007
 *
 * Specification:
 * SPEC-000010
 *
 * Author:
 * Phoenix Foundry
 *
 * Since:
 * 2.0.0
 *
 * PHP Version:
 * 8.2+
 * --------------------------------------------------------------------------
 */

declare(strict_types=1);

namespace Phoenix\Pipeline\DTO;

use JsonSerializable;

final readonly class StageResult implements JsonSerializable
{
    /**
     * @param array<string> $messages
     * @param array<string,mixed> $context
     */
    public function __construct(
        public string $stage,
        public bool $passed,
        public array $messages = [],
        public array $context = [],
        public float $executionTime = 0.0
    ) {
    }

    /**
     * Indicates whether the stage passed.
     */
    public function isPassed(): bool
    {
        return $this->passed;
    }

    /**
     * Indicates whether the stage failed.
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
            'stage' => $this->stage,
            'passed' => $this->passed,
            'messages' => $this->messages,
            'context' => $this->context,
            'executionTime' => $this->executionTime,
        ];
    }

    /**
     * Returns the result as a JSON-serializable array.
     *
     * @return array<string,mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}