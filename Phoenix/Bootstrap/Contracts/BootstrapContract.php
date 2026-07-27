<?php

declare(strict_types=1);

namespace Phoenix\Bootstrap\Contracts;

use Phoenix\Application\Contracts\ApplicationContract;

interface BootstrapContract
{
    /**
     * Create and bootstrap the application.
     */
    public function create(): ApplicationContract;
}