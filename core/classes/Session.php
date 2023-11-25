<?php

Autoloader::require('core/classes/i18n/Internationalization.php');

class Session
{

    public static function start(): void
    {
        if (self::isStarted()) return;
        session_start();
    }

    public static function isStarted(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function authenticated(): bool
    {
        return Session::authorized();
    }

    public static function authorized(): bool
    {
        return true;
    }

    public static function setLanguage(string $lang): void
    {
        $_SESSION["language"] = $lang;
    }

    public static function getLanguage(): ?string
    {
        return self::get("language");
    }

    public static function get(string $key)
    {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
        return null;
    }

    public static function remove(string $key): void
    {
        if (isset($_SESSION[$key]))
            unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        if (!self::isStarted()) return;
        session_destroy();
    }
}