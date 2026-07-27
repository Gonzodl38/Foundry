<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| Phoenix/Application/Providers/Provider.php
|
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
| Phoenix\Application\Providers
|
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Base implementation for Phoenix service providers.
*/

namespace Phoenix\Application\Providers;

use Phoenix\Application\Contracts\ApplicationContract;
use Phoenix\Application\Contracts\ProviderContract;

abstract class Provider implements ProviderContract
{
    /**
     * Creates a new provider.
     */
    public function __construct(
        protected readonly ApplicationContract $application
    ) {
    }

    /**
     * Register services into the application.
     */
    public function register(
        ApplicationContract $application
    ): void {
        // Default implementation.
    }

    /**
     * Boot the provider.
     */
    public function boot(
        ApplicationContract $application
    ): void {
        // Default implementation.
    }

    /**
     * Retrieve the application instance.
     */
    protected function application(): ApplicationContract
    {
        return $this->application;
    }
}