<?php
/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| C:\Projects\Phoenix\Engines\Activity\ActivityLogger.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Engines\Activity;

use PDO;
use PDOException;
use Throwable;

final class ActivityLogger
{
    private static ?PDO $connection = null;

    private function __construct()
    {
    }

    public static function login(?string $description = null): void
    {
        self::log(ActivityActions::LOGIN, $description);
    }

    public static function logout(?string $description = null): void
    {
        self::log(ActivityActions::LOGOUT, $description);
    }

    public static function view(?string $description = null): void
    {
        self::log(ActivityActions::VIEW, $description);
    }

    public static function export(
        string $report,
        ?string $description = null
    ): void {
        self::log(
            ActivityActions::EXPORT,
            $description,
            null,
            null,
            null,
            null,
            [
                'report' => $report,
            ]
        );
    }

    public static function custom(
        string $action,
        ?string $description = null,
        ?string $tableName = null,
        ?int $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $metadata = null
    ): void {
        self::log(
            $action,
            $description,
            $tableName,
            $recordId,
            $oldValues,
            $newValues,
            $metadata
        );
    }

    private static function log(
        string $action,
        ?string $description = null,
        ?string $tableName = null,
        ?int $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $metadata = null
    ): void {
        try {
            $context = ActivityContext::toArray();

            $statement = self::connection()->prepare(
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

            $statement->execute([
                ':user_id'       => $context['user_id'] ?? null,
                ':session_id'    => $context['session_id'] ?? null,
                ':request_uri'   => $context['request_uri'] ?? null,
                ':controller'    => $context['controller'] ?? null,
                ':action_method' => $context['action_method'] ?? null,
                ':module'        => $context['module'] ?? null,
                ':action_code'   => strtoupper($action),
                ':table_name'    => $tableName,
                ':record_id'     => $recordId,
                ':description'   => $description,
                ':old_values'    => self::json($oldValues),
                ':new_values'    => self::json($newValues),
                ':metadata'      => self::json($metadata),
            ]);
        } catch (Throwable) {
            // Silent failure by design.
        }
    }

    private static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $config = require dirname(__DIR__, 3) . '/Configuration/database.php';

        self::$connection = new PDO(
            sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                $config['host'],
                $config['database']
            ),
            $config['username'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );

        return self::$connection;
    }

    private static function json(?array $value): ?string
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