<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Verification\VerificationPipeline.php
 *
 * Artifact ID: PIPELINE-000001
 * File ID: FILE-000018
 *
 * Title:
 * Verification Pipeline
 *
 * Description:
 * Orchestrates the execution of every verification stage performed by
 * the Foundry.
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

namespace Phoenix\Verification;

final class VerificationPipeline
{
    /**
     * @var array<int, callable(): bool>
     */
    private array $stages = [];

    /**
     * Registers a verification stage.
     */
    public function addStage(callable $stage): self
    {
        $this->stages[] = $stage;

        return $this;
    }

    /**
     * Executes every registered verification stage.
     */
    public function execute(): bool
    {
        foreach ($this->stages as $stage) {
            if ($stage() !== true) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the number of registered stages.
     */
    public function count(): int
    {
        return count($this->stages);
    }

    /**
     * Indicates whether the pipeline is empty.
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * Removes every registered stage.
     */
    public function clear(): self
    {
        $this->stages = [];

        return $this;
    }
}