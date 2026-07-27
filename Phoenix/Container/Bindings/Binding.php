<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| Phoenix/Container/Bindings/Binding.php
|
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
| Phoenix\Container\Bindings
|
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Immutable implementation of a container binding.
*/

namespace Phoenix\Container\Bindings;

use Phoenix\Container\Contracts\BindingContract;

final class Binding implements BindingContract
{
    /**
     * Creates a new binding.
     *
     * @param string $abstract
     * @param mixed  $concrete
     * @param bool   $shared
     */
    public function __construct(
        private readonly string $abstract,
        private readonly mixed $concrete,
        private readonly bool $shared = false
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function abstract(): string
    {
        return $this->abstract;
    }

    /**
     * {@inheritDoc}
     */
    public function concrete(): mixed
    {
        return $this->concrete;
    }

    /**
     * {@inheritDoc}
     */
    public function shared(): bool
    {
        return $this->shared;
    }
}