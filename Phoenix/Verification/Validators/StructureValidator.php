<?php

/**
 * --------------------------------------------------------------------------
 * Phoenix Engineering Operating System (PEOS)
 * --------------------------------------------------------------------------
 *
 * Full Path: C:\Projects\Phoenix\Verification\Validators\StructureValidator.php
 *
 * Artifact ID: VALIDATOR-000001
 * File ID: FILE-000021
 *
 * Title:
 * Structure Validator
 *
 * Description:
 * Validates the minimum repository structure required by PEOS.
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

namespace Phoenix\Verification\Validators;

use Phoenix\Verification\Contracts\ValidatorContract;
use Phoenix\Verification\DTO\ValidationResult;

final class StructureValidator implements ValidatorContract
{
    /**
     * Directories required by PEOS.
     *
     * @var array<string>
     */
    private const REQUIRED_DIRECTORIES = [
        'Phoenix',
        'tools',
    ];

    /**
     * {@inheritDoc}
     */
    public function name(): string
    {
        return 'Repository Structure';
    }

    /**
     * {@inheritDoc}
     */
    public function description(): string
    {
        return 'Validates the required PEOS repository structure.';
    }

    /**
     * {@inheritDoc}
     */
    public function supports(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function priority(): int
    {
        return 0;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(): ValidationResult
    {
        $missing = [];

        foreach (self::REQUIRED_DIRECTORIES as $directory) {
            if (!is_dir($directory)) {
                $missing[] = $directory;
            }
        }

        if ($missing !== []) {
            return new ValidationResult(
                validator: $this->name(),
                passed: false,
                classification: 'FAIL',
                messages: [
                    'Required repository directories are missing.',
                ],
                context: [
                    'missing' => $missing,
                ]
            );
        }

        return new ValidationResult(
            validator: $this->name(),
            passed: true,
            classification: 'PASS',
            messages: [
                'Repository structure validated successfully.',
            ],
            context: [
                'directories' => self::REQUIRED_DIRECTORIES,
            ]
        );
    }
}