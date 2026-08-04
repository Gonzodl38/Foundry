<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Pipeline\PipelineEngine.php
 *
 * Artifact ID: ENGINE-000003
 * File ID: FILE-000022
 *
 * Title:
 * Pipeline Engine
 *
 * Description:
 * Generic execution engine responsible for orchestrating ordered stages.
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

namespace Phoenix\Pipeline;

use Phoenix\Pipeline\Contracts\StageContract;
use Phoenix\Pipeline\DTO\PipelineResult;
use Phoenix\Pipeline\DTO\StageResult;

final class PipelineEngine
{
    /**
     * @var array<int, StageContract>
     */
    private array $stages = [];

    /**
     * Registers a stage.
     */
    public function addStage(StageContract $stage): self
    {
        $this->stages[] = $stage;

        usort(
            $this->stages,
            static fn (
                StageContract $left,
                StageContract $right
            ): int => $left->priority() <=> $right->priority()
        );

        return $this;
    }

    /**
     * Executes the pipeline.
     */
    public function execute(): PipelineResult
    {
        $started = microtime(true);

        $results = [];

        foreach ($this->stages as $stage) {
            if (!$stage->supports()) {
                continue;
            }

            $result = $stage->execute();

            $results[] = $result;

            if ($result->isFailed()) {
                break;
            }
        }

        return new PipelineResult(
            results: $results,
            executionTime: microtime(true) - $started
        );
    }

    /**
     * Removes every registered stage.
     */
    public function clear(): self
    {
        $this->stages = [];

        return $this;
    }

    /**
     * Returns the registered stages.
     *
     * @return array<int, StageContract>
     */
    public function stages(): array
    {
        return $this->stages;
    }

    /**
     * Indicates whether the pipeline is empty.
     */
    public function isEmpty(): bool
    {
        return $this->stages === [];
    }

    /**
     * Returns the number of registered stages.
     */
    public function count(): int
    {
        return count($this->stages);
    }
}