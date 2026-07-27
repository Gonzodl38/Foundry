<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| Phoenix/Container/Contracts/ContainerContract.php
|
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
| Phoenix\Container\Contracts
|
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Defines the public contract for the Phoenix Dependency Injection
| Container.
*/

namespace Phoenix\Container\Contracts;

interface ContainerContract
{
    /**
     * Register a transient binding.
     */
    public function bind(
        string $abstract,
        mixed $concrete,
        bool $shared = false
    ): void;

    /**
     * Register a singleton binding.
     */
    public function singleton(
        string $abstract,
        mixed $concrete
    ): void;

    /**
     * Determine whether an abstract is registered.
     */
    public function has(string $abstract): bool;

    /**
     * Resolve an abstract.
     *
     * @throws \Phoenix\Container\Exceptions\ContainerException
     */
    public function resolve(string $abstract): mixed;
}