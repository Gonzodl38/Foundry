<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/CLI/Result.php
|--------------------------------------------------------------------------
*/

namespace Phoenix\CLI;

final class Result
{
    public function __construct(
        private readonly bool $success,
        private readonly string $message,
        private readonly int $exitCode = 0,
        private readonly array $data = []
    ) {
    }

    public static function success(
        string $message,
        array $data = []
    ): self {
        return new self(
            true,
            $message,
            0,
            $data
        );
    }

    public static function failure(
        string $message,
        int $exitCode = 1,
        array $data = []
    ): self {
        return new self(
            false,
            $message,
            $exitCode,
            $data
        );
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function exitCode(): int
    {
        return $this->exitCode;
    }

    public function data(): array
    {
        return $this->data;
    }
}