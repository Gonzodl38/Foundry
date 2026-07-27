<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| Phoenix/Container/Contracts/BindingContract.php
|
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
| Phoenix\Container\Contracts
|
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Defines the contract for a service binding stored by the Phoenix
| Container.
*/

namespace Phoenix\Container\Contracts;

interface BindingContract
{
    /**
     * Returns the abstract identifier being bound.
     */
    public function abstract(): string;

    /**
     * Returns the concrete implementation.
     *
     * @return mixed
     */
    public function concrete(): mixed;

    /**
     * Indicates whether the binding is shared (singleton).
     */
    public function shared(): bool;
}