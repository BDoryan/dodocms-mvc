<?php

class Routes
{

    const ADMIN_LOGIN = "/admin/login";
    const ADMIN_PANEL = "/admin";
    const ADMIN_TABLES = "/admin/tables";
    const ADMIN_TABLES_NEW = "/admin/tables/new";
    const ADMIN_TABLES_EDIT = "/admin/tables/edit/{table}";
    const ADMIN_TABLES_DELETE = "/admin/tables/delete/{table}";
    const ADMIN_TABLES_TABLE_ATTRIBUTE = "/admin/tables/attribute";
    const ADMIN_TABLES_TABLE_ENTRIES = "/admin/tables/entries/{table}";
    const ADMIN_TABLE_NEW_ENTRY = "/admin/tables/entries/{table}/new";
    const ADMIN_TABLE_EDIT_ENTRY = "/admin/tables/entries/{table}/edit/{id}";
    const ADMIN_TABLE_DELETE_ENTRY = "/admin/tables/entries/{table}/delete/{id}";

    public static function route(string $route, array $replaces = []): string
    {
        foreach ($replaces as $key => $value) {
            $route = str_replace("{" . $key . "}", $value, $route);
        }
        return Application::get()->toURL($route);
    }
}