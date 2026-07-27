<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| Phoenix/Application/Contracts/ApplicationContract.php
|
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
| Phoenix\Application\Contracts
|
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Defines the public contract for the Phoenix Application.
*/

namespace Phoenix\Application\Contracts;

use Phoenix\Container\Contracts\ContainerContract;

interface ApplicationContract
{
    /**
     * Register a service provider.
     */
    public function register(
        ProviderContract $provider
    ): void;

    /**
     * Boot the application.
     */
    public function boot(): void;

    /**
     * Determine whether the application has been booted.
     */
    public function booted(): bool;

    /**
     * Retrieve the application's container.
     */
    public function container(): ContainerContract;
}