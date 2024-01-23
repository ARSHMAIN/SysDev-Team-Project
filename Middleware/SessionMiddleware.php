<?php
namespace Middleware;
class SessionMiddleware
{
    public static function initializeSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public static function hasSessionVariable(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
    public static function getSessionVariable(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }
    public static function setSessionVariable(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }
    public static function unsetSessionVariable(string $key): void
    {
        unset($_SESSION[$key]);
    }
    public static function getAndClearFlashMessage(string $key): ?string
    {
        $message = self::getSessionVariable('flash')[$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    public static function setFlashMessage(string $key, string $message): void
    {
        $_SESSION['flash'][$key] = $message;
    }
    public static function destroySession(): void
    {
        session_unset();
        session_destroy();
    }
}