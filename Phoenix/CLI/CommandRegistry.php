<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/CLI/CommandRegistry.php
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Registers and resolves Phoenix CLI commands.
|--------------------------------------------------------------------------
*/

namespace Phoenix\CLI;

use InvalidArgumentException;
use Phoenix\Commands\ApplyCommand;
use Phoenix\Commands\DoctorCommand;
use Phoenix\Commands\HelpCommand;
use Phoenix\Commands\StatusCommand;
use Phoenix\Commands\VerifyCommand;

final class CommandRegistry
{
    /**
     * @var array<string, Command>
     */
    private array $commands = [];

    public function __construct()
    {
        $this->register(new HelpCommand());
        $this->register(new DoctorCommand());
        $this->register(new StatusCommand());
        $this->register(new VerifyCommand());
        $this->register(new ApplyCommand());
    }

    public function register(Command $command): void
    {
        $this->commands[$command->name()] = $command;
    }

    public function resolve(string $name): Command
    {
        if (! isset($this->commands[$name])) {
            throw new InvalidArgumentException(
                sprintf('Unknown command "%s". Run "phoenix help".', $name)
            );
        }

        return $this->commands[$name];
    }

    /**
     * @return array<string, Command>
     */
    public function all(): array
    {
        return $this->commands;
    }
}