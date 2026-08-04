<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/CLI/Context.php
|--------------------------------------------------------------------------
*/

namespace Phoenix\CLI;

final class Context
{
    public function __construct(
        private readonly array $argv
    ) {
    }

    public function command(): string
    {
        return $this->argv[1] ?? 'help';
    }

    public function arguments(): array
    {
        return array_slice($this->argv, 2);
    }

    public function argument(int $index): ?string
    {
        return $this->arguments()[$index] ?? null;
    }

    public function raw(): array
    {
        return $this->argv;
    }
}