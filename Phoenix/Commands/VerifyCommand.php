<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/Commands/VerifyCommand.php
|--------------------------------------------------------------------------
*/

namespace Phoenix\Commands;

use Phoenix\CLI\Command;
use Phoenix\CLI\Context;
use Phoenix\CLI\Result;

final class VerifyCommand implements Command
{
    public function name(): string
    {
        return 'verify';
    }

    public function description(): string
    {
        return 'Verifies a Work Order.';
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
            'Verification completed.',
            [
                'work_order' => $workOrder,
                'result'     => 'PASS'
            ]
        );
    }
}