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

declare(strict_types=1);

namespace Phoenix\Application;

use Phoenix\Application\Contracts\ApplicationContract;
use Phoenix\Application\Services\ApplicationService;
use Phoenix\Container\Contracts\ContainerContract;

final class Application implements ApplicationContract
{
    public function __construct(
        private readonly ApplicationContract $application = new ApplicationService()
    ) {
    }

    public function register(string $provider): void
    {
        $this->application->register($provider);
    }

    public function boot(): void
    {
        $this->application->boot();
    }

    public function booted(): bool
    {
        return $this->application->booted();
    }

    public function container(): ContainerContract
    {
        return $this->application->container();
    }
}