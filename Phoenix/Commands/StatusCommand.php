<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/Commands/StatusCommand.php
|--------------------------------------------------------------------------
*/

namespace Phoenix\Commands;

use Phoenix\CLI\Command;
use Phoenix\CLI\Context;
use Phoenix\CLI\Result;

final class StatusCommand implements Command
{
    public function name(): string
    {
        return 'status';
    }

    public function description(): string
    {
        return 'Displays Phoenix status.';
    }

    public function execute(Context $context): Result
    {
        return Result::success(
            'Phoenix ready.',
            [
                'repository' => 'READY',
                'workspace'  => 'READY',
                'artifact'   => 'NONE',
                'transaction'=> 'IDLE'
            ]
        );
    }
}