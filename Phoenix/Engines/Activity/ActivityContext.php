<?php
/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| C:\Projects\Phoenix\Engines\Activity\ActivityContext.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Engines\Activity;

use DateTimeImmutable;

final class ActivityContext
{
    private static ?int $userId = null;
    private static string $sessionId = '';
    private static string $requestUri = '';
    private static string $controller = '';
    private static string $actionMethod = '';
    private static string $module = 'home';
    private static string $requestMethod = 'GET';
    private static string $ipAddress = '';
    private static string $userAgent = '';
    private static ?DateTimeImmutable $timestamp = null;
    private static bool $initialized = false;

    private function __construct()
    {
    }

    public static function initialize(
        ?int $userId = null,
        ?string $controller = null,
        ?string $actionMethod = null,
        ?string $module = null
    ): void {
        self::$userId = $userId;
        self::$sessionId = session_id();
        self::$requestUri = trim($_SERVER['REQUEST_URI'] ?? '/');
        self::$requestMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        self::$controller = $controller ?? '';
        self::$actionMethod = $actionMethod ?? '';
        self::$module = $module ?? self::detectModule(self::$requestUri);
        self::$ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
        self::$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        self::$timestamp = new DateTimeImmutable();
        self::$initialized = true;
    }

    public static function isInitialized(): bool
    {
        return self::$initialized;
    }

    public static function refresh(
        ?string $controller = null,
        ?string $actionMethod = null,
        ?string $module = null
    ): void {
        self::$requestUri = trim($_SERVER['REQUEST_URI'] ?? '/');
        self::$requestMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        if ($controller !== null) {
            self::$controller = $controller;
        }

        if ($actionMethod !== null) {
            self::$actionMethod = $actionMethod;
        }

        if ($module !== null) {
            self::$module = $module;
        }

        self::$timestamp = new DateTimeImmutable();
    }

    public static function setUser(?int $userId): void
    {
        self::$userId = $userId;
    }

    public static function userId(): ?int
    {
        return self::$userId;
    }

    public static function sessionId(): string
    {
        return self::$sessionId;
    }

    public static function requestUri(): string
    {
        return self::$requestUri;
    }

    public static function controller(): string
    {
        return self::$controller;
    }

    public static function actionMethod(): string
    {
        return self::$actionMethod;
    }

    public static function module(): string
    {
        return self::$module;
    }

    public static function requestMethod(): string
    {
        return self::$requestMethod;
    }

    public static function ipAddress(): string
    {
        return self::$ipAddress;
    }

    public static function userAgent(): string
    {
        return self::$userAgent;
    }

    public static function timestamp(): DateTimeImmutable
    {
        return self::$timestamp ?? new DateTimeImmutable();
    }

    public static function toArray(): array
    {
        return [
            'user_id'        => self::$userId,
            'session_id'     => self::$sessionId,
            'request_uri'    => self::$requestUri,
            'controller'     => self::$controller,
            'action_method'  => self::$actionMethod,
            'module'         => self::$module,
            'request_method' => self::$requestMethod,
            'ip_address'     => self::$ipAddress,
            'user_agent'     => self::$userAgent,
            'timestamp'      => self::timestamp()->format('Y-m-d H:i:s'),
        ];
    }

    private static function detectModule(string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH);

        if (!$path) {
            return 'home';
        }

        $path = trim($path, '/');

        if ($path === '') {
            return 'home';
        }

        return strtolower(explode('/', $path)[0]);
    }
}