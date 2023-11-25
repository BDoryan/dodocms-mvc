<?php

class Cache {

    private static array $cache = [];

    public static function set(string $key, $value): void {
        self::$cache[$key] = $value;
    }

    public static function get(string $key) {
        if (isset(self::$cache[$key]))
            return self::$cache[$key];
        return null;
    }

    public static function unset(string $key): void {
        if (isset(self::$cache[$key]))
            unset(self::$cache[$key]);
    }
}