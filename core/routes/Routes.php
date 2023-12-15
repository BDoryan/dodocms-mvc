<?php

Autoloader::require("core/controllers/PanelController.php");
Autoloader::require("core/controllers/TableManagementController.php");
Autoloader::require("core/controllers/ResourcesManagerController.php");
Autoloader::require("core/controllers/api/resources/ApiResourcesController.php");
Autoloader::require("core/controllers/page/PageController.php");
Autoloader::require("core/controllers/api/DefaultApiController.php");
Autoloader::require("core/controllers/api/model/ApiModelController.php");
Autoloader::require("core/controllers/api/page/ApiPageController.php");
Autoloader::require("core/classes/Application.php");
Autoloader::require("core/classes/Router.php");

class Routes
{

    const ADMIN_LOGIN = "/admin/login";
    const ADMIN_PANEL = "/admin";

    /**
     * Tables routes
     */
    const ADMIN_TABLES = "/admin/tables";
    const ADMIN_TABLES_NEW = "/admin/tables/new";
    const ADMIN_TABLES_EDIT = "/admin/tables/edit/{table}";
    const ADMIN_TABLES_DELETE = "/admin/tables/delete/{table}";
    const ADMIN_TABLES_TABLE_ATTRIBUTE = "/admin/tables/attribute";
    const ADMIN_TABLES_TABLE_ENTRIES = "/admin/tables/{table}/entries";

    /**
     * Entries of tables routes
     */
    const ADMIN_TABLE_NEW_ENTRY = "/admin/tables/{table}/entries/new";
    const ADMIN_TABLE_EDIT_ENTRY = "/admin/tables/{table}/entries/edit/{id}";
    const ADMIN_TABLE_DELETE_ENTRY = "/admin/tables/{table}/entries/delete/{id}";
    const ADMIN_RESOURCES_MANAGER = "/admin/resources/";

    /**
     * Pages routes
     */
    const ADMIN_PAGES_MANAGER = "/admin/pages";
    const ADMIN_PAGES_MANAGER_NEW = "/admin/pages/new";
    const ADMIN_PAGES_MANAGER_EDIT = "/admin/pages/edit/{id}";
    const ADMIN_PAGES_MANAGER_DELETE = "/admin/pages/delete/{id}";

    /**
     * Resources api routes
     */
    const ADMIN_API_UPLOAD_RESOURCE = "/admin/api/resources/upload";
    const ADMIN_API_GET_HTML_RESOURCE = "/admin/api/resources/html/{id}";
    const ADMIN_API_EDIT_RESOURCE = "/admin/api/resources/edit/{id}";
    const ADMIN_API_GET_RESOURCE = "/admin/api/resources/get/{id}";
    const ADMIN_API_GET_RESOURCES = "/admin/api/resources/";
    const ADMIN_API_DELETE_RESOURCE = "/admin/api/resources/delete/{id}";
    const ADMIN_API_PAGE_STRUCTURE_EDIT = "/admin/api/pages/edit/{id}";
    const ADMIN_API_PAGE_STRUCTURE_BLOCKS = "/admin/api/pages/blocks/{id}";

    /**
     * Entity of table api routes
     */
    const ADMIN_API_TABLE_ENTITY = "/admin/api/entries/update/{model}/{id}";

    /**
     * Default api route
     */
    const ADMIN_API = "/admin/api.*";

    public static function loadRoutes(Application $application, Router $router)
    {
        $adminController = new PanelController();
        $ptmController = new TableManagementController();
        $resourcesManagerController = new ResourcesManagerController();
        $defaultApiController = new DefaultApiController();
        $apiModelController = new ApiModelController();
        $apiResourcesController = new ApiResourcesController();
        $apiPageController = new ApiPageController();

        $router->get(self::ADMIN_PANEL, [$adminController, 'index']);
        $router->get(self::ADMIN_LOGIN, [$adminController, 'login']);
        $router->post(self::ADMIN_LOGIN, [$adminController, 'authentication']);

        /**
         * Table routes
         */
        $router->get(self::ADMIN_TABLES, [$ptmController, 'tables']);
        $router->get(self::ADMIN_TABLES_TABLE_ATTRIBUTE, [$ptmController, 'attribute']);
        $router->get(self::ADMIN_TABLES_NEW, [$ptmController, 'new']);
        $router->post(self::ADMIN_TABLES_NEW, [$ptmController, 'new']);
        $router->get(self::ADMIN_TABLES_EDIT, [$ptmController, 'edit']);
        $router->post(self::ADMIN_TABLES_EDIT, [$ptmController, 'edit']);
        $router->post(self::ADMIN_TABLES_DELETE, [$ptmController, 'delete']);

        /**
         * Entries routes
         */
        $router->get(self::ADMIN_TABLES_TABLE_ENTRIES, [$ptmController, 'entries']);
        $router->get(self::ADMIN_TABLE_NEW_ENTRY, [$ptmController, 'newEntry']);
        $router->post(self::ADMIN_TABLE_NEW_ENTRY, [$ptmController, 'newEntry']);
        $router->get(self::ADMIN_TABLE_EDIT_ENTRY, [$ptmController, 'editEntry']);
        $router->post(self::ADMIN_TABLE_EDIT_ENTRY, [$ptmController, 'editEntry']);
        $router->get(self::ADMIN_TABLE_DELETE_ENTRY, [$ptmController, 'deleteEntry']);

        /**
         * Api
         */
        $router->post(self::ADMIN_API_TABLE_ENTITY, [$apiModelController, 'setEntry']);

        /**
         * Resources manager routes
         */
        $router->get(self::ADMIN_RESOURCES_MANAGER, [$resourcesManagerController, 'index']);
        $router->get(self::ADMIN_API_GET_HTML_RESOURCE, [$resourcesManagerController, 'getResource']);

        /**
         * Pages manager routes
         */
        $router->post(self::ADMIN_API_PAGE_STRUCTURE_EDIT, [$apiPageController, 'editStructure']);
        $router->get(self::ADMIN_API_PAGE_STRUCTURE_BLOCKS, [$apiPageController, 'editStructure']);
//        $router->get(self::ADMIN_PAGES_MANAGER, [$ptmController, 'entries']);
//        $router->get(self::ADMIN_PAGES_MANAGER_NEW, [$ptmController, 'newEntry']);
//        $router->post(self::ADMIN_PAGES_MANAGER_NEW, [$ptmController, 'newEntry']);
//        $router->get(self::ADMIN_PAGES_MANAGER_EDIT, [$ptmController, 'editEntry']);
//        $router->post(self::ADMIN_PAGES_MANAGER_EDIT, [$ptmController, 'editEntry']);
//        $router->get(self::ADMIN_PAGES_MANAGER_DELETE, [$ptmController, 'deleteEntry']);

        /**
         * Api routes
         */
        $router->post(self::ADMIN_API_UPLOAD_RESOURCE, [$apiResourcesController, "upload"]);
        $router->put(self::ADMIN_API_EDIT_RESOURCE, [$apiResourcesController, "edit"]);
        $router->delete(self::ADMIN_API_DELETE_RESOURCE, [$apiResourcesController, "delete"]);
        $router->get(self::ADMIN_API_GET_RESOURCE, [$apiResourcesController, "get"]);
        $router->get(self::ADMIN_API_GET_RESOURCES, [$apiResourcesController, "all"]);
        $router->get(self::ADMIN_API, [$defaultApiController, "notFound"]);

//        $router->get('/test', function () {
//            new ModelGenerator("Client", ["name", "email", "phone_number", "address"]);
//        });

        /**
         * Section route
         */
        $router->get(self::ADMIN_PANEL . "/{section}", [$adminController, 'section']);

        $pageController = new PageController();

        /**
         * Pages routes
         */
        $pages  = PageModel::findAll("*");
        foreach ($pages as $page) {
            $router->get($page->getSlug(), function () use ($page, $pageController) {
                $pageController->viewPage($page);
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
        foreach ($replaces as $key => $value) {
            $route = str_replace("{" . $key . "}", $value, $route);
        }
        return Application::get()->toURL($route);
    }
}