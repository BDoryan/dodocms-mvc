<?php

Autoloader::require('core/admin/sections/BlocksSection.php');
Autoloader::require('core/admin/sections/PagesSection.php');
Autoloader::require('core/admin/sections/ResourcesSection.php');
Autoloader::require('core/admin/sections/ConfigurationSection.php');
Autoloader::require('core/admin/sections/TablesSection.php');
Autoloader::require('core/admin/sections/UsersSection.php');

Autoloader::require("core/admin/controllers/PanelController.php");
Autoloader::require("core/admin/controllers/page/PageController.php");
Autoloader::require("core/classes/Application.php");
Autoloader::require("core/classes/Router.php");

class DefaultRoutes
{

    const ADMIN_LOGIN = "/admin/login";
    const ADMIN_LOGOUT = "/admin/logout";
    const ADMIN_PANEL = "/admin";

    /* Tables routes */
    const ADMIN_TABLES = "/admin/tables";
    const ADMIN_TABLES_NEW = "/admin/tables/new";
    const ADMIN_TABLES_EDIT = "/admin/tables/edit/{table}";
    const ADMIN_TABLES_DELETE = "/admin/tables/delete/{table}";
    const ADMIN_TABLES_TABLE_ATTRIBUTE = "/admin/tables/attribute";
    const ADMIN_TABLES_TABLE_ENTRIES = "/admin/tables/{table}/entries";

    /* Entries of tables routes */
    const ADMIN_TABLE_NEW_ENTRY = "/admin/tables/{table}/entries/new";
    const ADMIN_TABLE_EDIT_ENTRY = "/admin/tables/{table}/entries/edit/{id}";
    const ADMIN_TABLE_DELETE_ENTRY = "/admin/tables/{table}/entries/delete/{id}";

    /* Pages panel routes */
    const ADMIN_BLOCKS_MANAGER = "/admin/blocks";
    const ADMIN_CONFIGURATION = "/admin/configuration";
    const ADMIN_USERS_MANAGER_NEW = "/admin/users/new";

    const ADMIN_PAGES_MANAGER_NEW = "/admin/pages/new";
    const ADMIN_PAGES_MANAGER_EDIT = "/admin/pages/edit/{id}";
    const ADMIN_PAGES_MANAGER_DELETE = "/admin/pages/delete/{id}";

    /* Resources api routes */
    const ADMIN_API_UPLOAD_RESOURCE = "/admin/api/resources/upload";
    const ADMIN_API_GET_HTML_RESOURCE = "/admin/api/resources/html/{id}";
    const ADMIN_API_EDIT_RESOURCE = "/admin/api/resources/edit/{id}";
    const ADMIN_API_GET_RESOURCE = "/admin/api/resources/get/{id}";
    const ADMIN_API_GET_RESOURCES = "/admin/api/resources/";
    const ADMIN_API_DELETE_RESOURCE = "/admin/api/resources/delete/{id}";
    const ADMIN_API_PAGE_STRUCTURE_EDIT = "/admin/api/pages/edit/{id}";
    const ADMIN_API_PAGE_STRUCTURE_ADD_BLOCK = "/admin/api/pages/add";
    const ADMIN_API_PAGE_STRUCTURE_DELETE_BLOCK = "/admin/api/pages/delete/{id}";
    const ADMIN_API_PAGE_STRUCTURE_BLOCK_MOVE_TO_UP = "/admin/api/pages/move/up/{id}";
    const ADMIN_API_PAGE_STRUCTURE_BLOCK_MOVE_TO_DOWN = "/admin/api/pages/move/down/{id}";

    /* Entity of table api routes */
    const ADMIN_API_TABLE_EDIT_ENTITY = "/admin/api/entries/set/{model}/{id}";
    const ADMIN_API_TABLE_DELETE_ENTITY = "/admin/api/entries/delete/{model}/{id}";
    const ADMIN_API_TABLE_NEW_ENTITY = "/admin/api/entries/set/{model}";
    const ADMIN_API_TABLE_ENTITY_FORM = "/admin/api/entries/form/{model}";

    /* Sections */
    const ADMIN_RESOURCES_MANAGER = "/admin/resources/";
    const ADMIN_PAGES_MANAGER = "/admin/pages";
    const ADMIN_USERS = "/admin/users";

    /* Default api route */
    const ADMIN_API = "/admin/api.*";

    public static function loadRoutes(Application $application, Router $router)
    {
        $adminController = new PanelController();
        $pageController = new PageBuilderController();

        // Panels routes
        $router->get(self::ADMIN_LOGIN, [$adminController, 'login']);
        $router->get(self::ADMIN_LOGOUT, [$adminController, 'logout']);
        $router->post(self::ADMIN_LOGIN, [$adminController, 'authentication']);

        $sections = Application::get()->getSections();
        foreach ($sections as $route) {
            $route->routes($router);
        }

        $router->middleware([$adminController, 'authorization'],
            $router->get(self::ADMIN_PANEL, [$adminController, 'index']),
        );

        $pages = PageModel::findAll("*");
        foreach ($pages as $page) {
            $router->get($page->getSlug(), function () use ($adminController, $page, $pageController) {
                $pageController->viewPage($adminController, $page);
            });
        }
    }

    public static function getRoute(string $route, array $replaces = []): string
    {
        foreach ($replaces as $key => $value) {
            $route = str_replace("{" . $key . "}", $value, $route);
        }
        return $route;
    }

    public static function route(string $route, array $replaces = []): string
    {
        $route = self::getRoute($route, $replaces);
        return Application::get()->toURL($route);
    }
}