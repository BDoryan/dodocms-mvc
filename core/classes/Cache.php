<?php

class Cache {

    private static array $cache = [];

    /**
     * Store cache data in memory (just during the request)
     *
     * @param string $key
     * @param $value
     * @return void
     */
    public static function set(string $key, $value): void {
        self::$cache[$key] = $value;
    }

    /**
     * Get cache data from memory (just during the request)
     *
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $key) {
        if (isset(self::$cache[$key]))
            return self::$cache[$key];
        return null;
    }

    /**
     * Remove cache data from memory (just during the request)
     *
     * @param string $key
     * @return void
     */
    public static function unset(string $key): void {
        if (isset(self::$cache[$key]))
            unset(self::$cache[$key]);
    }

    /**
     * Get a file from cache
     *
     * @param string $file the name of the file
     * @return string|null if file exists, the path to the file, else null
     */
    public static function readFileInCache(string $file): ?string
    {
        $dir = Application::get()->toRoot('/cache/tmp');
        $file = $dir . '/' . $file;
        if (file_exists($file))
            return file_get_contents($file);
        return null;
    }

    /**
     * Return the path to a file in cache
     *
     * @param string|null $file if null, a random name will be generated
     * @param string|null $extension if not null, the extension of the file
     * @return string|null
     */
    public static function toFileInCache(?string $file, ?string $extension = null): ?string
    {
        if($file == null)
            $file = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 5)), 0, 5);

        if($extension != null)
            $file = $file . $extension;

        $dir = Application::get()->toRoot('/cache/tmp');
        return $dir . '/' . $file;
    }

    /**
     * Store a file in cache
     *
     * @param string|null $file if null, a random name will be generated
     * @param string $content the content of the file
     * @return string the final name of the file
     */
    public static function storeFileInCache(?string $file, string $content): string
    {
        $file = self::toFileInCache($file);
        $dir = dirname($file);

        if (!file_exists($dir))
            mkdir($dir, 0777, true);
        file_put_contents($file, $content);
        return $file;
    }
}