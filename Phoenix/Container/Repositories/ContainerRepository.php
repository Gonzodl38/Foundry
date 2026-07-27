<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| Phoenix/Container/Repositories/ContainerRepository.php
|
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
| Phoenix\Container\Repositories
|
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Stores and retrieves container bindings.
|
| The repository is responsible only for persistence of bindings.
| It does not resolve, instantiate or validate dependencies.
*/

namespace Phoenix\Container\Repositories;

use Phoenix\Container\Bindings\Binding;
use Phoenix\Container\Contracts\BindingContract;

final class ContainerRepository
{
    /**
     * Registered bindings.
     *
     * @var array<string, BindingContract>
     */
    private array $bindings = [];

    /**
     * Register a binding.
     */
    public function set(BindingContract $binding): void
    {
        $this->bindings[$binding->abstract()] = $binding;
    }

    /**
     * Determine whether a binding exists.
     */
    public function has(string $abstract): bool
    {
        return array_key_exists($abstract, $this->bindings);
    }

    /**
     * Retrieve a binding.
     */
    public function get(string $abstract): ?BindingContract
    {
        return $this->bindings[$abstract] ?? null;
    }

    /**
     * Remove a binding.
     */
    public function remove(string $abstract): void
    {
        unset($this->bindings[$abstract]);
    }

    /**
     * Remove every registered binding.
     */
    public function clear(): void
    {
        $this->bindings = [];
    }

    /**
     * Return every registered binding.
     *
     * @return array<string, BindingContract>
     */
    public function all(): array
    {
        return $this->bindings;
    }

    /**
     * Number of registered bindings.
     */
    public function count(): int
    {
        return count($this->bindings);
    }

    /**
     * Determine whether the repository is empty.
     */
    public function isEmpty(): bool
    {
        return empty($this->bindings);
    }
}