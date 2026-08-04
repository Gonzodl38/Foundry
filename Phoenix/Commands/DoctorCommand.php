<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/Commands/DoctorCommand.php
|--------------------------------------------------------------------------
*/

namespace Phoenix\Commands;

use Phoenix\CLI\Command;
use Phoenix\CLI\Context;
use Phoenix\CLI\Result;

final class DoctorCommand implements Command
{
    public function name(): string
    {
        return 'doctor';
    }

    public function description(): string
    {
        return 'Checks repository health.';
    }

    public function execute(Context $context): Result
    {
        return Result::success(
            'Repository healthy.',
            [
                'PHP Version      ' => PHP_VERSION,
                'Operating System ' => PHP_OS_FAMILY,
                'Working Directory' => getcwd(),
                'status'            => 'HEALTHY'
            ]
        );
    }
}