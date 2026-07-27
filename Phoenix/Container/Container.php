<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| Phoenix/Container/Container.php
|
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
| Phoenix\Container
|
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Public façade for the Phoenix Dependency Injection Container.
|
| This class represents the entry point to the Container subsystem.
*/

namespace Phoenix\Container;

use Phoenix\Container\Contracts\ContainerContract;
use Phoenix\Container\Services\ContainerService;

final class Container implements ContainerContract
{
    /**
     * Creates a new Container instance.
     */
    public function __construct(
        private readonly ContainerContract $container = new ContainerService()
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function bind(
        string $abstract,
        mixed $concrete,
        bool $shared = false
    ): void {
        $this->container->bind($abstract, $concrete, $shared);
    }

    /**
     * {@inheritDoc}
     */
    public function singleton(
        string $abstract,
        mixed $concrete
    ): void {
        $this->container->singleton($abstract, $concrete);
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $abstract): bool
    {
        return $this->container->has($abstract);
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(string $abstract): mixed
    {
        return $this->container->resolve($abstract);
    }
}