#!/usr/bin/env php
<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/tools/phoenix
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Phoenix CLI launcher.
|--------------------------------------------------------------------------
*/

use Phoenix\CLI\Application;

$autoload = dirname(__DIR__) . '/vendor/autoload.php';

if (!file_exists($autoload)) {
    fwrite(STDERR, "Autoloader not found.\nRun composer install.\n");
    exit(1);
}

require $autoload;

$app = new Application();

exit($app->run($argv));