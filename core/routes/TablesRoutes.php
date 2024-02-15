<?php

class TablesRoutes extends Section
{

    public function __construct()
    {
        parent::__construct(new TablesController(), new ApiTablesController());
    }

    public function routes(Router $router): void
    {
        $router->middleware([$this->getController(), 'authorization'],
            /* TABLES */
            $router->get(NativeRoutes::ADMIN_TABLES, [$this->getController(), 'tables']),
            $router->get(NativeRoutes::ADMIN_TABLES_TABLE_ATTRIBUTE, [$this->getController(), 'attribute']),
            $router->get(NativeRoutes::ADMIN_TABLES_NEW, [$this->getController(), 'new']),
            $router->post(NativeRoutes::ADMIN_TABLES_NEW, [$this->getController(), 'new']),
            $router->get(NativeRoutes::ADMIN_TABLES_EDIT, [$this->getController(), 'edit']),
            $router->post(NativeRoutes::ADMIN_TABLES_EDIT, [$this->getController(), 'edit']),
            $router->post(NativeRoutes::ADMIN_TABLES_DELETE, [$this->getController(), 'delete']),

            /* MODELS (ENTRIES) */
            $router->get(NativeRoutes::ADMIN_TABLES_TABLE_ENTRIES, [$this->getController(), 'entries']),
            $router->get(NativeRoutes::ADMIN_TABLE_NEW_ENTRY, [$this->getController(), 'newEntry']),
            $router->post(NativeRoutes::ADMIN_TABLE_NEW_ENTRY, [$this->getController(), 'newEntry']),
            $router->get(NativeRoutes::ADMIN_TABLE_EDIT_ENTRY, [$this->getController(), 'editEntry']),
            $router->post(NativeRoutes::ADMIN_TABLE_EDIT_ENTRY, [$this->getController(), 'editEntry']),
            $router->get(NativeRoutes::ADMIN_TABLE_DELETE_ENTRY, [$this->getController(), 'deleteEntry']),
        );

        $router->middleware([$this->getApiController(), 'authorization'],
            $router->post(NativeRoutes::ADMIN_API_TABLE_EDIT_ENTITY, [$this->getApiController(), 'setEntry']),
            $router->post(NativeRoutes::ADMIN_API_TABLE_NEW_ENTITY, [$this->getApiController(), 'setEntry']),
            $router->post(NativeRoutes::ADMIN_API_TABLE_DELETE_ENTITY, [$this->getApiController(), 'deleteEntry']),
            $router->get(NativeRoutes::ADMIN_API_TABLE_ENTITY_FORM, [$this->getApiController(), 'getForm']),
        );
    }
}