<?php

class ControllerManager
{

    private static array $controllers = [];

    /**
     * Add a controller to the controller manager with the view name
     *
     * @param $bview_name
     * @param $controller
     * @return void
     */
    public static function addController(string $view, $controller): void
    {
        self::$controllers[$view] = $controller;
    }

    public static function load(string $view): void {
        if(!isset(self::$controllers[$view]))
            throw new Exception("Controller not found for view $view");

        self::$controllers[$view].load();
    }

    /**
     * Get a controller with the view name
     *
     * @param $view
     * @return mixed
     */
    public static function getController($view)
    {
        return self::$controllers[$view];
    }

    public static function getControllers(): array
    {
        return self::$controllers;
    }
}