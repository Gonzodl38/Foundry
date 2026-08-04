<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/CLI/Application.php
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Main Phoenix CLI application.
|--------------------------------------------------------------------------
*/

namespace Phoenix\CLI;

use Throwable;

final class Application
{
    private CommandRegistry $registry;

    public function __construct()
    {
        $this->registry = new CommandRegistry();
    }

    public function run(array $argv): int
    {
        try {

            $context = new Context($argv);

            $command = $this->registry->resolve(
                $context->command()
            );

            $result = $command->execute($context);

            $this->render($result);

            return $result->exitCode();

        } catch (Throwable $e) {

            fwrite(STDERR, PHP_EOL);
            fwrite(STDERR, "Phoenix Fatal Error" . PHP_EOL);
            fwrite(STDERR, $e->getMessage() . PHP_EOL);

            return 1;
        }
    }

    private function render(Result $result): void
    {
        echo PHP_EOL;
        echo "Phoenix Foundry" . PHP_EOL;
        echo "===============================" . PHP_EOL;
        echo "Status : " . ($result->isSuccess() ? "PASS" : "FAIL") . PHP_EOL;
        echo "Message: " . $result->message() . PHP_EOL;

        foreach ($result->data() as $key => $value) {
            echo ucfirst($key) . ": {$value}" . PHP_EOL;
        }

        echo PHP_EOL;
    }
}