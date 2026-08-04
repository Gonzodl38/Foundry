<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/Commands/HelpCommand.php
|--------------------------------------------------------------------------
*/

namespace Phoenix\Commands;

use Phoenix\CLI\Command;
use Phoenix\CLI\Context;
use Phoenix\CLI\Result;

final class HelpCommand implements Command
{
    public function name(): string
    {
        return 'help';
    }

    public function description(): string
    {
        return 'Displays available commands.';
    }

    public function execute(Context $context): Result
    {
        return Result::success(
            'Available commands',
            [
                'doctor' => 'Check repository health',
                'status' => 'Display current status',
                'verify' => 'Verify a work order',
                'apply'  => 'Execute a work order',
                'help'   => 'Display this help'
            ]
        );
    }
}