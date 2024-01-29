<?php

class Tools
{

    public static function parseJsonToHtmlAttribute(string $json) {
        $json = str_replace("'", "\'", $json);
        return str_replace("\"", "'", $json);
    }

    public static function randomId($begin): string
    {
        return $begin . "-" . self::uuid();
    }

    public static function toURI(string $path): string
    {
        $path = self::addFirstSlash($path);
        return self::removeLastSlash($path);
    }

    public static function containsItems(array $items, string $method, $value): bool
    {
        foreach ($items as $item) {
            if ($item->$method() == $value)
                return true;
        }
        return false;
    }

    public static function getCurrentURI($withGet = true): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        if($withGet)
            return $uri;

        return explode('?', $uri)[0];
    }

    public static function removeLastSlash(string $path): string
    {
        if (substr($path, -1) === '/')
            return substr($path, 0, -1);
        return $path;
    }

    public static function removeFirstSlash(string $path): string
    {
        if (substr($path, 0, 1) === '/')
            return substr($path, 1);
        return $path;
    }

    public static function addFirstSlash(string $path): string
    {
        if (substr($path, 0, 1) !== '/')
            return '/' . $path;
        return $path;
    }

    public static function addLastSlash(string $path): string
    {
        if (substr($path, -1) !== '/')
            return $path . '/';
        return $path;
    }

    public static function getPut(): array
    {
        $_PUT = [];
        parse_str(file_get_contents('php://input'), $_PUT);
        return $_PUT;
    }

    public static function underscoreToCamelCase($string, $capitalizeFirstCharacter = true)
    {
        Application::get()->getLogger()->info($string);
        $str = str_replace('_', '', ucwords($string, '_'));
        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }
        Application::get()->getLogger()->info($str);
        return $str;
    }

    public static function slugify(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text); // Convertit les caractères UTF-8 en ASCII
        $text = preg_replace('~[^-\w]+~', '', $text); // Supprime les caractères non-ASCII
        $text = trim($text, '-'); // Supprime les tirets en début et fin de chaîne
        $text = preg_replace('~-+~', '-', $text); // Remplace les tirets multiples par un seul tiret
        $text = strtolower($text); // Convertit en minuscules
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    public static function getMimeType($path): ?string
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $path);
        finfo_close($finfo);
        return $mime_type;
    }

    public static function endsWith(string $str, string $endsWith): bool
    {
        $length = strlen($endsWith);
        if ($length == 0) {
            return true;
        }
        return (substr($str, -$length) === $endsWith);
    }

    public static function startsWith(string $str, string $startsWith): bool
    {
        $length = strlen($startsWith);
        return substr($str, 0, $length) === $startsWith;
    }

    public static function getColumnData($columnType): array
    {
        ;
        $pattern = "/^([a-zA-Z]+)\((\d+)\)$/"; // Pattern pour rechercher le type et la longueur
        $matches = [];

        if (preg_match($pattern, $columnType, $matches)) {
            $columnValue = $matches[1];  // Contient le type (e.g., "int")
            $columnLength = $matches[2]; // Contient la longueur (e.g., "11")
            return [
                "type" => $columnValue,
                "length" => $columnLength
            ];
        }
        return ["type" => $columnType];
    }

    public static function uuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}