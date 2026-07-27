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

declare(strict_types=1);

namespace Phoenix\Application\Services;

use Phoenix\Application\Contracts\ApplicationContract;
use Phoenix\Application\Contracts\ProviderContract;
use Phoenix\Application\Exceptions\ApplicationException;
use Phoenix\Container\Container;
use Phoenix\Container\Contracts\ContainerContract;

final class ApplicationService implements ApplicationContract
{
    /**
     * @var array<ProviderContract>
     */
    private array $providers = [];

    private bool $booted = false;

    public function __construct(
        private readonly ContainerContract $container = new Container()
    ) {
    }

    public function register(string $provider): void
    {
        if ($this->booted) {
            throw new ApplicationException(
                'Cannot register providers after the application has booted.'
            );
        }

        if (! class_exists($provider)) {
            throw new ApplicationException(
                sprintf(
                    'Provider [%s] does not exist.',
                    $provider
                )
            );
        }

        $instance = new $provider($this);

        if (! $instance instanceof ProviderContract) {
            throw new ApplicationException(
                sprintf(
                    '[%s] is not a valid provider.',
                    $provider
                )
            );
        }

        $instance->register();

        $this->providers[] = $instance;
    }

    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        foreach ($this->providers as $provider) {
            $provider->boot();
        }

        $this->booted = true;
    }

    public function booted(): bool
    {
        return $this->booted;
    }

    public function container(): ContainerContract
    {
        return $this->container;
    }
}