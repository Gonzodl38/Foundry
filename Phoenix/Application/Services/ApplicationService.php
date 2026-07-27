<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| Phoenix/Application/Services/ApplicationService.php
|
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
| Phoenix\Application\Services
|
|--------------------------------------------------------------------------
| Purpose
|--------------------------------------------------------------------------
| Default implementation of the Phoenix Application lifecycle.
*/

namespace Phoenix\Application\Services;

use Phoenix\Application\Contracts\ApplicationContract;
use Phoenix\Application\Contracts\ProviderContract;
use Phoenix\Application\Exceptions\ApplicationException;
use Phoenix\Container\Container;
use Phoenix\Container\Contracts\ContainerContract;

final class ApplicationService implements ApplicationContract
{
    /**
     * Registered service providers.
     *
     * @var array<ProviderContract>
     */
    private array $providers = [];

    /**
     * Indicates whether the application has been booted.
     */
    private bool $booted = false;

    /**
     * Creates a new application.
     */
    public function __construct(
        private readonly ContainerContract $container = new Container()
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function register(
        ProviderContract $provider
    ): void {
        if ($this->booted) {
            throw new ApplicationException(
                'Cannot register providers after the application has booted.'
            );
        }

        $provider->register($this);

        $this->providers[] = $provider;
    }

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        foreach ($this->providers as $provider) {
            $provider->boot($this);
        }

        $this->booted = true;
    }

    /**
     * {@inheritDoc}
     */
    public function booted(): bool
    {
        return $this->booted;
    }

    /**
     * {@inheritDoc}
     */
    public function container(): ContainerContract
    {
        return $this->container;
    }
}