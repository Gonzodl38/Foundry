<?php

declare(strict_types=1);

namespace Phoenix\Registry\Contracts;

interface ProviderContract
{
    /**
     * Register services into the application.
     */
    public function register(): void;

    /**
     * Boot the provider after all registrations.
     */
    public function boot(): void;

    /**
     * Indicates whether the provider has been booted.
     */
    public function isBooted(): bool;

    /**
     * Returns the provider name.
     */
    public function getName(): string;
}