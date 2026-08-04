<?php
/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| C:\Projects\Phoenix\Container\Repositories\ContainerRepository.php
|--------------------------------------------------------------------------
| Artifact
|--------------------------------------------------------------------------
| CONTAINER-000002.1
|--------------------------------------------------------------------------
| Replace this file with this implementation.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Container\Repositories;

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
     * Singleton instances.
     *
     * @var array<string, mixed>
     */
    private array $instances = [];

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
     * Determine whether a singleton instance exists.
     */
    public function hasInstance(string $abstract): bool
    {
        return array_key_exists($abstract, $this->instances);
    }

    /**
     * Retrieve a singleton instance.
     */
    public function getInstance(string $abstract): mixed
    {
        return $this->instances[$abstract] ?? null;
    }

    /**
     * Store a singleton instance.
     */
    public function setInstance(
        string $abstract,
        mixed $instance
    ): void {
        $this->instances[$abstract] = $instance;
    }

    /**
     * Remove a singleton instance.
     */
    public function removeInstance(string $abstract): void
    {
        unset($this->instances[$abstract]);
    }

    /**
     * Remove a binding.
     */
    public function remove(string $abstract): void
    {
        unset($this->bindings[$abstract]);
        unset($this->instances[$abstract]);
    }

    /**
     * Remove every registered binding and instance.
     */
    public function clear(): void
    {
        $this->bindings = [];
        $this->instances = [];
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