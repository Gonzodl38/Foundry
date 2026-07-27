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

declare(strict_types=1);

namespace Phoenix\Application\Providers;

use Phoenix\Application\Contracts\ApplicationContract;
use Phoenix\Application\Contracts\ProviderContract;

abstract class Provider implements ProviderContract
{
    public function __construct(
        protected readonly ApplicationContract $application
    ) {
    }

    protected function application(): ApplicationContract
    {
        return $this->application;
    }

    public function register(): void
    {
        // Default implementation.
    }

    public function boot(): void
    {
        // Default implementation.
    }
}