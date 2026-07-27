<?php

declare(strict_types=1);

namespace Phoenix\Bootstrap\Providers;

use Phoenix\Application\Providers\Provider;

final class CoreProvider extends Provider
{
    /**
     * Register core framework services.
     */
    public function register(): void
    {
        // Reserved for foundational framework services.
    }

    /**
     * Boot the core framework.
     */
    public function boot(): void
    {
        // Reserved for framework startup tasks.
    }
}