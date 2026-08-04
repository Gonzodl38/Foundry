<?php
/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| C:\Projects\Phoenix\Engines\Activity\ActivityActions.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Engines\Activity;

final class ActivityActions
{
    public const LOGIN  = 'LOGIN';
    public const LOGOUT = 'LOGOUT';

    public const VIEW   = 'VIEW';

    public const INSERT = 'INSERT';
    public const UPDATE = 'UPDATE';
    public const DELETE = 'DELETE';

    public const EXPORT = 'EXPORT';
    public const IMPORT = 'IMPORT';
    public const PRINT  = 'PRINT';

    public const CUSTOM = 'CUSTOM';

    /**
     * Returns all supported action codes.
     */
    public static function all(): array
    {
        return [
            self::LOGIN,
            self::LOGOUT,

            self::VIEW,

            self::INSERT,
            self::UPDATE,
            self::DELETE,

            self::EXPORT,
            self::IMPORT,
            self::PRINT,

            self::CUSTOM,
        ];
    }

    /**
     * Determines whether the supplied action is valid.
     */
    public static function exists(string $action): bool
    {
        return in_array(
            strtoupper($action),
            self::all(),
            true
        );
    }

    /**
     * Normalizes an action code.
     */
    public static function normalize(string $action): string
    {
        return strtoupper(trim($action));
    }

    /**
     * Returns the action if valid; otherwise CUSTOM.
     */
    public static function resolve(string $action): string
    {
        $action = self::normalize($action);

        return self::exists($action)
            ? $action
            : self::CUSTOM;
    }

    private function __construct()
    {
    }
}