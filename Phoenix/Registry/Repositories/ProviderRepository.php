<?php

declare(strict_types=1);

namespace Phoenix\Registry\Repositories;

use Phoenix\Registry\Contracts\ProviderContract;
use Phoenix\Registry\Exceptions\RegistryException;

class ProviderRepository
{
    /**
     * @var array<string, ProviderContract>
     */
    private array $providers = [];

    public function add(ProviderContract $provider): void
    {
        $this->providers[$provider->getName()] = $provider;
    }

    public function has(string $name): bool
    {
        return isset($this->providers[$name]);
    }

    public function get(string $name): ProviderContract
    {
        if (! $this->has($name)) {
            throw new RegistryException(
                sprintf('Provider "%s" was not found.', $name)
            );
        }

        return $this->providers[$name];
    }

    /**
     * @return iterable<ProviderContract>
     */
    public function all(): iterable
    {
        return array_values($this->providers);
    }

    public function registerAll(): void
    {
        foreach ($this->providers as $provider) {
            $provider->register();
        }
    }

    public function bootAll(): void
    {
        foreach ($this->providers as $provider) {
            if (! $provider->isBooted()) {
                $provider->boot();
            }
        }
    }
}