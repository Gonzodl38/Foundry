<?php

declare(strict_types=1);

namespace Phoenix\Bootstrap;

use Phoenix\Application\Contracts\ApplicationContract;
use Phoenix\Bootstrap\Contracts\BootstrapContract;
use Phoenix\Bootstrap\Services\BootstrapService;

final class Bootstrap implements BootstrapContract
{
    public function __construct(
        private readonly BootstrapContract $bootstrap = new BootstrapService()
    ) {
    }

    /**
     * Create and bootstrap the application.
     */
    public function create(): ApplicationContract
    {
        return $this->bootstrap->create();
    }

    /**
     * Create a ready-to-use application.
     */
    public static function make(): ApplicationContract
    {
        return (new self())->create();
    }
}