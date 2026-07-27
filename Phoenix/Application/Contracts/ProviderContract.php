<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| Phoenix/Application/Contracts/ProviderContract.php
|
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
| Phoenix\Application\Contracts
|
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Defines the lifecycle contract for Phoenix service providers.
*/

namespace Phoenix\Application\Contracts;

interface ProviderContract
{
    /**
     * Register services into the application.
     */
    public function register(
        ApplicationContract $application
    ): void;

    /**
     * Boot the provider.
     */
    public function boot(
        ApplicationContract $application
    ): void;
}