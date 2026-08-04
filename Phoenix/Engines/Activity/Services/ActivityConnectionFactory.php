<?php
/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| C:\Projects\Phoenix\Engines\Activity\Services\ActivityConnectionFactory.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Engines\Activity\Services;

use PDO;
use PDOException;

final class ActivityConnectionFactory
{
    private static ?PDO $connection = null;

    private function __construct()
    {
    }

    public static function make(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $database = require dirname(__DIR__, 3)
            . '/Configuration/database.php';

        self::$connection = new PDO(
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
                PDO::ATTR_PERSISTENT         => false,
            ]
        );

        return self::$connection;
    }
}