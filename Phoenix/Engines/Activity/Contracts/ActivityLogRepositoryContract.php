<?php
/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| C:\Projects\Phoenix\Engines\Activity\Contracts\ActivityLogRepositoryContract.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Engines\Activity\Contracts;

use Phoenix\Engines\Activity\DTO\ActivityEntry;

interface ActivityLogRepositoryContract
{
    /**
     * Persist an activity entry.
     */
    public function save(ActivityEntry $entry): bool;
}