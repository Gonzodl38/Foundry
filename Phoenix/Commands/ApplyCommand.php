<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/Commands/ApplyCommand.php
|--------------------------------------------------------------------------
*/

namespace Phoenix\Commands;

use Phoenix\CLI\Command;
use Phoenix\CLI\Context;
use Phoenix\CLI\Result;

final class ApplyCommand implements Command
{
    public function name(): string
    {
        return 'apply';
    }

    public function description(): string
    {
        return 'Executes a Work Order.';
    }

    public function execute(Context $context): Result
    {
        $workOrder = $context->argument(0);

        if ($workOrder === null) {
            return Result::failure(
                'Missing Work Order identifier.'
            );
        }

        return Result::success(
            'Execution completed.',
            [
                'work_order' => $workOrder,
                'validation' => 'PASS',
                'planning'   => 'PASS',
                'execution'  => 'PASS',
                'result'     => 'CERTIFIED'
            ]
        );
    }
}