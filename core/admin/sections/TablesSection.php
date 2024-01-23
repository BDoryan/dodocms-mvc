<?php

class TablesSection extends Section
{

    public function __construct()
    {
        parent::__construct(new TablesController(), new ApiTablesController());
    }

    public function routes(Router $router): void
    {
        $router->middleware([$this->getController(), 'authorization'],
            /* TABLES */
            $router->get(DefaultRoutes::ADMIN_TABLES, [$this->getController(), 'tables']),
            $router->get(DefaultRoutes::ADMIN_TABLES_TABLE_ATTRIBUTE, [$this->getController(), 'attribute']),
            $router->get(DefaultRoutes::ADMIN_TABLES_NEW, [$this->getController(), 'new']),
            $router->post(DefaultRoutes::ADMIN_TABLES_NEW, [$this->getController(), 'new']),
            $router->get(DefaultRoutes::ADMIN_TABLES_EDIT, [$this->getController(), 'edit']),
            $router->post(DefaultRoutes::ADMIN_TABLES_EDIT, [$this->getController(), 'edit']),
            $router->post(DefaultRoutes::ADMIN_TABLES_DELETE, [$this->getController(), 'delete']),

            /* MODELS (ENTRIES) */
            $router->get(DefaultRoutes::ADMIN_TABLES_TABLE_ENTRIES, [$this->getController(), 'entries']),
            $router->get(DefaultRoutes::ADMIN_TABLE_NEW_ENTRY, [$this->getController(), 'newEntry']),
            $router->post(DefaultRoutes::ADMIN_TABLE_NEW_ENTRY, [$this->getController(), 'newEntry']),
            $router->get(DefaultRoutes::ADMIN_TABLE_EDIT_ENTRY, [$this->getController(), 'editEntry']),
            $router->post(DefaultRoutes::ADMIN_TABLE_EDIT_ENTRY, [$this->getController(), 'editEntry']),
            $router->get(DefaultRoutes::ADMIN_TABLE_DELETE_ENTRY, [$this->getController(), 'deleteEntry']),
        );

        $router->middleware([$this->getApiController(), 'authorization'],
            $router->post(DefaultRoutes::ADMIN_API_TABLE_EDIT_ENTITY, [$this->getApiController(), 'setEntry']),
            $router->post(DefaultRoutes::ADMIN_API_TABLE_NEW_ENTITY, [$this->getApiController(), 'setEntry']),
            $router->post(DefaultRoutes::ADMIN_API_TABLE_DELETE_ENTITY, [$this->getApiController(), 'deleteEntry']),
            $router->get(DefaultRoutes::ADMIN_API_TABLE_ENTITY_FORM, [$this->getApiController(), 'getForm']),
        );
    }
}