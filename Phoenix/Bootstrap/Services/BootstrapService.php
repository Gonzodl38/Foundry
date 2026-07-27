<?php

declare(strict_types=1);

namespace Phoenix\Bootstrap\Services;

use Phoenix\Application\Application;
use Phoenix\Application\Contracts\ApplicationContract;
use Phoenix\Bootstrap\Contracts\BootstrapContract;
use Phoenix\Bootstrap\Providers\CoreProvider;

final class BootstrapService implements BootstrapContract
{
    /**
     * Create and bootstrap the application.
     */
    public function create(): ApplicationContract
    {
        $application = new Application();

        foreach ($this->providers() as $provider) {
            $application->register($provider);
        }

        $application->boot();

        return $application;
    }

    /**
     * Retrieve the framework providers.
     *
     * @return array<class-string<\Phoenix\Application\Providers\Provider>>
     */
    protected function providers(): array
    {
        return [
            CoreProvider::class,
        ];
    }
}