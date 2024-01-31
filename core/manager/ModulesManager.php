<?php

class ModulesManager
{

    private static array $modules = [];

    public function __construct()
    {
        $this->loadModules();
    }

    /**
     * @return array
     */
    public static function getModules(): array
    {
        return self::$modules;
    }

    /**
     * Load all modules
     *
     * @return void
     */
    public static function loadModules(): void
    {
        $dir = Application::get()->toRoot('/modules');
        $modules = scandir($dir);
        foreach ($modules as $module) {
            if ($module === '.' || $module === '..') continue;
            $moduleDir = $dir . '/' . $module;

            if (!is_dir($moduleDir)) continue;
            $moduleFile = $moduleDir . '/index.php';

            if (!file_exists($moduleFile)) continue;
            require_once $moduleFile;

            $indexContent = file_get_contents($moduleFile);
            preg_match('/class\s(\w+)/', $indexContent, $matches);
            $className = $matches[1];

            Application::get()->getLogger()->info('Module found: ' . $module . ' (' . $className . ')');

            Autoloader::require($moduleDir.'/classes', true);
            Autoloader::require($moduleDir.'/models', true);
            Autoloader::require($moduleDir.'/controllers', true);
            Autoloader::require($moduleDir.'/routes', true);

            /** @var Module $moduleClass */
            $moduleClass = new $className();
            self::$modules[$module] = $moduleClass;

            Application::get()->getLogger()->info('Module ' . $module . ' load...');
            $moduleClass->loadModule();

            Application::get()->getLogger()->info('Module ' . $module . ' loaded');
        }
    }
}