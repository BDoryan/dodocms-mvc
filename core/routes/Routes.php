<?php

class Routes
{

    const ADMIN_LOGIN = "/admin/login";
    const ADMIN_PANEL = "/admin";
    const ADMIN_TABLES = "/admin/tables";
    const ADMIN_TABLES_NEW = "/admin/tables/new";

    public static function route(string $route): string
    {
        return Application::get()->toURL($route);
    }
}