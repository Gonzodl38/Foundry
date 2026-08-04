<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/CLI/Command.php
|--------------------------------------------------------------------------
*/

namespace Phoenix\CLI;

interface Command
{
    public function name(): string;

    public function description(): string;

    public function execute(Context $context): Result;
}