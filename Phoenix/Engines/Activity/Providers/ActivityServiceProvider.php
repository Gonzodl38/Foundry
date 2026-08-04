<?php
/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| C:\Projects\Phoenix\Engines\Activity\Providers\ActivityServiceProvider.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Engines\Activity\Providers;

use Phoenix\Container\Contracts\ContainerContract;
use Phoenix\Engines\Activity\ActivityEngine;
use Phoenix\Engines\Activity\Contracts\ActivityEngineContract;
use Phoenix\Engines\Activity\Contracts\ActivityLogRepositoryContract;
use Phoenix\Engines\Activity\Repositories\ActivityLogRepository;
use Phoenix\Engines\Activity\Services\ActivityConnectionFactory;
use Phoenix\Engines\Activity\Services\ActivityLoggerService;

final class ActivityServiceProvider
{
    public function register(ContainerContract $container): void
    {
        $container->singleton(
            ActivityLogRepositoryContract::class,
            static fn (): ActivityLogRepositoryContract =>
                new ActivityLogRepository(
                    ActivityConnectionFactory::make()
                )
        );

        $container->singleton(
            ActivityLoggerService::class,
            static fn () => new ActivityLoggerService(
                $container->get(ActivityLogRepositoryContract::class)
            )
        );

        $container->singleton(
            ActivityEngineContract::class,
            static fn (): ActivityEngineContract =>
                new ActivityEngine(
                    $container->get(ActivityLoggerService::class)
                )
        );
    }
}