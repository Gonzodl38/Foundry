<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| Phoenix/Application/Application.php
|
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
| Phoenix\Application
|
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Public façade for the Phoenix Application.
|
| This class represents the composition root of the framework.
*/

namespace Phoenix\Application;

use Phoenix\Application\Contracts\ApplicationContract;
use Phoenix\Application\Contracts\ProviderContract;
use Phoenix\Application\Services\ApplicationService;
use Phoenix\Container\Contracts\ContainerContract;

final class Application implements ApplicationContract
{
    /**
     * Creates a new Application instance.
     */
    public function __construct(
        private readonly ApplicationContract $application = new ApplicationService()
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function register(
        ProviderContract $provider
    ): void {
        $this->application->register($provider);
    }

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        $this->application->boot();
    }

    /**
     * {@inheritDoc}
     */
    public function booted(): bool
    {
        return $this->application->booted();
    }

    /**
     * {@inheritDoc}
     */
    public function container(): ContainerContract
    {
        return $this->application->container();
    }
}