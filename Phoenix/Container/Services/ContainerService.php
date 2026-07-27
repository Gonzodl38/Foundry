<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| Phoenix/Container/Services/ContainerService.php
|
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
| Phoenix\Container\Services
|
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Default implementation of the Phoenix Dependency Injection
| Container.
*/

namespace Phoenix\Container\Services;

use Closure;
use Phoenix\Container\Bindings\Binding;
use Phoenix\Container\Contracts\ContainerContract;
use Phoenix\Container\Exceptions\ContainerException;
use Phoenix\Container\Repositories\ContainerRepository;
use ReflectionClass;
use ReflectionException;

final class ContainerService implements ContainerContract
{
    /**
     * Registered bindings.
     */
    public function __construct(
        private readonly ContainerRepository $repository = new ContainerRepository()
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
        $this->repository->set(
            new Binding(
                abstract: $abstract,
                concrete: $concrete,
                shared: $shared
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function singleton(
        string $abstract,
        mixed $concrete
    ): void {
        $this->bind(
            abstract: $abstract,
            concrete: $concrete,
            shared: true
        );
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $abstract): bool
    {
        return $this->repository->has($abstract);
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(string $abstract): mixed
    {
        $binding = $this->repository->get($abstract);

        if ($binding === null) {
            throw new ContainerException(
                sprintf(
                    'Container binding [%s] is not registered.',
                    $abstract
                )
            );
        }

        $concrete = $binding->concrete();

        if ($concrete instanceof Closure) {
            return $concrete();
        }

        if (is_object($concrete)) {
            return $concrete;
        }

        if (is_string($concrete)) {
            return $this->build($concrete);
        }

        return $concrete;
    }

    /**
     * Instantiate a class using reflection.
     *
     * @throws ContainerException
     */
    private function build(string $class): object
    {
        try {
            $reflection = new ReflectionClass($class);

            if (! $reflection->isInstantiable()) {
                throw new ContainerException(
                    sprintf(
                        'Class [%s] is not instantiable.',
                        $class
                    )
                );
            }

            $constructor = $reflection->getConstructor();

            if ($constructor === null) {
                return new $class();
            }

            if ($constructor->getNumberOfRequiredParameters() === 0) {
                return new $class();
            }

            throw new ContainerException(
                sprintf(
                    'Automatic constructor injection for [%s] is not implemented.',
                    $class
                )
            );
        } catch (ReflectionException $exception) {
            throw new ContainerException(
                sprintf(
                    'Unable to resolve [%s].',
                    $class
                ),
                previous: $exception
            );
        }
    }
}