<?php

class Autoloader
{

    const DEBUG_MODE = false;

    public static function require($target, $subdirectory = false)
    {
        if(is_file($target)) {
            if (self::DEBUG_MODE)
                echo '<strong>require_once ' . $target . '<br></strong>';

            require_once $target;
            return;
        }

        if (self::DEBUG_MODE)
            echo __DIR__ . " ($target)<br> ";

        $files = glob($target . '/*');

        foreach ($files as $file) {
            if(self::DEBUG_MODE)
                echo "<span style='font-weight: 900; color: darkgreen'>$file</span>". '<br>';

            if (is_file($file)) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    if (self::DEBUG_MODE)
                        echo '<strong>require_once ' . $file . '<br></strong>';

                    require_once $file;
                }
            } elseif (is_dir($file) && $subdirectory)
                self::require($file, $subdirectory);

        }
    }
}