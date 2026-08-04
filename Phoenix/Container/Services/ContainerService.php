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
use Phoenix\Container\Exceptions\CircularDependencyException;
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
     * Tracks the current dependency resolution chain.
     *
     * Used to detect circular dependencies during recursive
     * dependency injection.
     *
     * @var string[]
     */
    private array $resolutionStack = [];
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

        /*
        |--------------------------------------------------------------------------
        | Return cached singleton
        |--------------------------------------------------------------------------
        */

        if (
            $binding->shared()
            && $this->repository->hasInstance($abstract)
        ) {
            return $this->repository->getInstance($abstract);
        }

        /*
        |--------------------------------------------------------------------------
        | Resolve binding
        |--------------------------------------------------------------------------
        */

        $concrete = $binding->concrete();

        if ($concrete instanceof Closure) {
            $instance = $concrete();
        } elseif (is_object($concrete)) {
            $instance = $concrete;
        } elseif (is_string($concrete)) {
            $instance = $this->build($concrete);
        } else {
            $instance = $concrete;
        }

        /*
        |--------------------------------------------------------------------------
        | Cache singleton
        |--------------------------------------------------------------------------
        */

        if ($binding->shared()) {
            $this->repository->setInstance(
                $abstract,
                $instance
            );
        }

        return $instance;

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

            if (!$reflection->isInstantiable()) {
                throw new ContainerException(
                    sprintf(
                        'Class [%s] is not instantiable.',
                        $class
                    )
                );
            }

            $constructor = $reflection->getConstructor();

            /*
            |--------------------------------------------------------------------------
            | No constructor
            |--------------------------------------------------------------------------
            */

            if ($constructor === null) {
                return new $class();
            }

            /*
            |--------------------------------------------------------------------------
            | Constructor without parameters
            |--------------------------------------------------------------------------
            */

            if ($constructor->getNumberOfRequiredParameters() === 0) {
                return new $class();
            }
            /*
            |--------------------------------------------------------------------------
            | Resolve constructor dependencies
            |--------------------------------------------------------------------------
            */

            $dependencies = [];

            foreach ($constructor->getParameters() as $parameter) {

                
                if (!$type instanceof \ReflectionNamedType) {
                    throw new ContainerException(
                        sprintf(
                            'Unsupported reflection type while building [%s].',
                            $class
                        )
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Untyped parameter
                |--------------------------------------------------------------------------
                */

                if ($type === null) {

                    if ($parameter->isDefaultValueAvailable()) {
                        $dependencies[] = $parameter->getDefaultValue();
                        continue;
                    }

                    throw new ContainerException(
                        sprintf(
                            'Unable to resolve parameter [$%s] while building [%s].',
                            $parameter->getName(),
                            $class
                        )
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Primitive parameter
                |--------------------------------------------------------------------------
                */

                if ($type->isBuiltin()) {

                    if ($parameter->isDefaultValueAvailable()) {
                        $dependencies[] = $parameter->getDefaultValue();
                        continue;
                    }

                    throw new ContainerException(
                        sprintf(
                            'Cannot autowire builtin parameter [$%s] of [%s].',
                            $parameter->getName(),
                            $class
                        )
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Resolve class/interface recursively
                |--------------------------------------------------------------------------
                */

                $dependency = $type->getName();

                if (!$this->repository->has($dependency)) {

                    if ($parameter->isDefaultValueAvailable()) {
                        $dependencies[] = $parameter->getDefaultValue();
                        continue;
                    }

                    throw new ContainerException(
                        sprintf(
                            'Dependency [%s] required by [%s] is not registered.',
                            $dependency,
                            $class
                        )
                    );
                }

                $dependencies[] = $this->resolve($dependency);
            }

            /*
            |--------------------------------------------------------------------------
            | Instantiate
            |--------------------------------------------------------------------------
            */

            return $reflection->newInstanceArgs($dependencies);

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

    /**
     * Marks the beginning of a dependency resolution.
     *
     * @throws CircularDependencyException
     */
    private function enterResolution(string $class): void
    {
        if (in_array($class, $this->resolutionStack, true)) {
            throw CircularDependencyException::fromStack(
                $this->resolutionStack,
                $class
            );
        }

        $this->resolutionStack[] = $class;
    }

    /**
     * Marks the end of a dependency resolution.
     */
    private function leaveResolution(): void
    {
        array_pop($this->resolutionStack);
    }

}