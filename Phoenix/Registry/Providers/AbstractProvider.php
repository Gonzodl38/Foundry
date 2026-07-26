<?php

declare(strict_types=1);

namespace Phoenix\Registry\Providers;

use Phoenix\Registry\Contracts\ProviderContract;

abstract class AbstractProvider implements ProviderContract
{
    private bool $booted = false;

    public function register(): void
    {
        // Override in concrete providers.
    }

    public function boot(): void
    {
        $this->booted = true;
    }

    public function isBooted(): bool
    {
        return $this->booted;
    }

    public function getName(): string
    {
        return static::class;
    }
}