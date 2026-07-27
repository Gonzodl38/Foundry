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

declare(strict_types=1);

namespace Phoenix\Application\Contracts;

interface ProviderContract
{
    /**
     * Register services.
     */
    public function register(): void;

    /**
     * Boot services.
     */
    public function boot(): void;
}