<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Pipeline\Contracts\StageContract.php
 *
 * Artifact ID: CONTRACT-000005
 * File ID: FILE-000024
 *
 * Title:
 * Stage Contract
 *
 * Description:
 * Defines the contract implemented by every executable pipeline stage.
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

namespace Phoenix\Pipeline\Contracts;

use Phoenix\Pipeline\DTO\StageResult;

interface StageContract
{
    /**
     * Returns the stage name.
     */
    public function name(): string;

    /**
     * Returns the stage description.
     */
    public function description(): string;

    /**
     * Indicates whether this stage can execute.
     */
    public function supports(): bool;

    /**
     * Returns the execution priority.
     *
     * Lower values execute first.
     */
    public function priority(): int;

    /**
     * Executes the stage.
     */
    public function execute(): StageResult;
}