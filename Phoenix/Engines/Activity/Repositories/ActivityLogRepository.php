<?php
/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| C:\Projects\Phoenix\Engines\Activity\Repositories\ActivityLogRepository.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Engines\Activity\Repositories;

use PDO;
use PDOException;
use Phoenix\Engines\Activity\DTO\ActivityEntry;

use Phoenix\Engines\Activity\Contracts\ActivityLogRepositoryContract;

final class ActivityLogRepository implements ActivityLogRepositoryContract
{    public function __construct(
        private readonly PDO $connection
    ) {
    }

    public function save(ActivityEntry $entry): bool
    {
        $statement = $this->connection->prepare(
            <<<SQL
INSERT INTO activity_log
(
    created_at,
    user_id,
    session_id,
    request_uri,
    controller,
    action_method,
    module,
    action_code,
    table_name,
    record_id,
    description,
    old_values,
    new_values,
    metadata
)
VALUES
(
    CURRENT_TIMESTAMP,
    :user_id,
    :session_id,
    :request_uri,
    :controller,
    :action_method,
    :module,
    :action_code,
    :table_name,
    :record_id,
    :description,
    :old_values,
    :new_values,
    :metadata
)
SQL
        );

        return $statement->execute(
            $entry->toDatabase()
        );
    }
}