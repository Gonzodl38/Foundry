<?php

declare(strict_types=1);

namespace Phoenix\Registry\Services;

use Phoenix\Registry\Contracts\ProviderContract;
use Phoenix\Registry\Repositories\ProviderRepository;

final readonly class ProviderService
{
    public function __construct(
        private ProviderRepository $repository,
    ) {
    }

    public function registerProvider(ProviderContract $provider): void
    {
        $this->repository->add($provider);
    }

    public function hasProvider(string $name): bool
    {
        return $this->repository->has($name);
    }

    public function getProvider(string $name): ProviderContract
    {
        return $this->repository->get($name);
    }

    /**
     * @return iterable<ProviderContract>
     */
    public function providers(): iterable
    {
        return $this->repository->all();
    }

    public function registerAll(): void
    {
        $this->repository->registerAll();
    }

    public function bootAll(): void
    {
        $this->repository->bootAll();
    }
}