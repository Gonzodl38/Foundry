<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Verification\Contracts\ValidatorContract.php
 *
 * Artifact ID: CONTRACT-000004
 * File ID: FILE-000019
 *
 * Title:
 * Validator Contract
 *
 * Description:
 * Defines the contract implemented by every verification validator.
 *
 * Work Order:
 * WO-000006
 *
 * Specification:
 * SPEC-000009
 *
 * Author:
 * Phoenix Foundry
 *
 * Since:
 * 1.1.0
 *
 * PHP Version:
 * 8.2+
 * --------------------------------------------------------------------------
 */

declare(strict_types=1);

namespace Phoenix\Verification\Contracts;

use Phoenix\Verification\DTO\ValidationResult;

interface ValidatorContract
{
    /**
     * Returns the validator name.
     */
    public function name(): string;

    /**
     * Returns the validator description.
     */
    public function description(): string;

    /**
     * Indicates whether the validator can execute.
     */
    public function supports(): bool;

    /**
     * Returns the execution priority.
     *
     * Lower values execute first.
     */
    public function priority(): int;

    /**
     * Executes a single validation.
     */
    public function execute(): ValidationResult;
}
