<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Pipeline\DTO\PipelineResult.php
 *
 * Artifact ID: DTO-000005
 * File ID: FILE-000025
 *
 * Title:
 * Pipeline Result
 *
 * Description:
 * Immutable result representing the execution of a complete pipeline.
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

final readonly class PipelineResult implements JsonSerializable
{
    /**
     * @param array<int, StageResult> $results
     */
    public function __construct(
        public array $results = [],
        public float $executionTime = 0.0
    ) {
    }

    /**
     * Indicates whether every stage passed.
     */
    public function isPassed(): bool
    {
        foreach ($this->results as $result) {
            if ($result->isFailed()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Indicates whether at least one stage failed.
     */
    public function isFailed(): bool
    {
        return !$this->isPassed();
    }

    /**
     * Returns the number of executed stages.
     */
    public function stageCount(): int
    {
        return count($this->results);
    }

    /**
     * Returns the result as an array.
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'passed' => $this->isPassed(),
            'executionTime' => $this->executionTime,
            'stageCount' => $this->stageCount(),
            'results' => array_map(
                static fn(StageResult $result): array => $result->toArray(),
                $this->results
            ),
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