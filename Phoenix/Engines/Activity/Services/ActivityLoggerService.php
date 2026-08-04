<?php
/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| C:\Projects\Phoenix\Engines\Activity\Services\ActivityLoggerService.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Engines\Activity\Services;

use PDO;
use PDOException;
use Throwable;
use Phoenix\Engines\Activity\ActivityActions;
use Phoenix\Engines\Activity\ActivityContext;

final class ActivityLoggerService
{
    private ?PDO $connection = null;

    public function __construct(?PDO $connection = null)
    {
        $this->connection = $connection;
    }

    public function login(?string $description = null): void
    {
        $this->write(
            ActivityActions::LOGIN,
            $description
        );
    }

    public function logout(?string $description = null): void
    {
        $this->write(
            ActivityActions::LOGOUT,
            $description
        );
    }

    public function view(?string $description = null): void
    {
        $this->write(
            ActivityActions::VIEW,
            $description
        );
    }

    public function insert(
        string $tableName,
        int|string|null $recordId = null,
        ?array $newValues = null,
        ?string $description = null
    ): void {
        $this->write(
            ActivityActions::INSERT,
            $description,
            $tableName,
            $recordId,
            null,
            $newValues
        );
    }

    public function update(
        string $tableName,
        int|string|null $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null
    ): void {
        $this->write(
            ActivityActions::UPDATE,
            $description,
            $tableName,
            $recordId,
            $oldValues,
            $newValues
        );
    }

    public function delete(
        string $tableName,
        int|string|null $recordId = null,
        ?array $oldValues = null,
        ?string $description = null
    ): void {
        $this->write(
            ActivityActions::DELETE,
            $description,
            $tableName,
            $recordId,
            $oldValues
        );
    }

    public function export(
        string $report,
        ?string $description = null
    ): void {
        $this->write(
            ActivityActions::EXPORT,
            $description,
            metadata: [
                'report' => $report,
            ]
        );
    }

    public function import(
        string $source,
        ?string $description = null
    ): void {
        $this->write(
            ActivityActions::IMPORT,
            $description,
            metadata: [
                'source' => $source,
            ]
        );
    }

    public function print(
        string $document,
        ?string $description = null
    ): void {
        $this->write(
            ActivityActions::PRINT,
            $description,
            metadata: [
                'document' => $document,
            ]
        );
    }

    public function custom(
        string $action,
        ?string $description = null,
        ?string $tableName = null,
        int|string|null $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $metadata = null
    ): void {
        $this->write(
            ActivityActions::resolve($action),
            $description,
            $tableName,
            $recordId,
            $oldValues,
            $newValues,
            $metadata
        );
    }

    private function write(
        string $action,
        ?string $description = null,
        ?string $tableName = null,
        int|string|null $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $metadata = null
    ): void {
        try {
            $context = ActivityContext::toArray();

            $statement = $this->connection()
                ->prepare($this->sql());

            $statement->execute([
                ':user_id'       => $context['user_id'],
                ':session_id'    => $context['session_id'],
                ':request_uri'   => $context['request_uri'],
                ':controller'    => $context['controller'],
                ':action_method' => $context['action_method'],
                ':module'        => $context['module'],
                ':action_code'   => $action,
                ':table_name'    => $tableName,
                ':record_id'     => $recordId,
                ':description'   => $description,
                ':old_values'    => $this->json($oldValues),
                ':new_values'    => $this->json($newValues),
                ':metadata'      => $this->json($metadata),
            ]);
        } catch (Throwable) {
            // Never interrupt business execution.
        }
    }

    private function connection(): PDO
    {
        if ($this->connection instanceof PDO) {
            return $this->connection;
        }

        $database = require dirname(__DIR__, 3)
            . '/Configuration/database.php';

        $this->connection = new PDO(
            sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                $database['host'],
                $database['database']
            ),
            $database['username'],
            $database['password'],
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );

        return $this->connection;
    }

    private function sql(): string
    {
        return <<<SQL
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
SQL;
    }

    private function json(?array $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return json_encode(
            $value,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
            | JSON_THROW_ON_ERROR
        );
    }
}