<?php

class Routes
{

    const ADMIN_LOGIN = "/admin/login";
    const ADMIN_PANEL = "/admin";
    const ADMIN_TABLES = "/admin/tables";
    const ADMIN_TABLES_NEW = "/admin/tables/new";
    const ADMIN_TABLES_EDIT = "/admin/tables/edit/{table}";

    public static function route(string $route, array $replaces = []): string
    {
        foreach ($replaces as $key => $value) {
            $route = str_replace("{" . $key . "}", $value, $route);
        }
        return Application::get()->toURL($route);
    }
}