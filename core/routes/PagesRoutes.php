<?php

class PagesRoutes extends Section
{

    public function __construct()
    {
        parent::__construct(new PagesController(), new ApiPagesController());
    }

    public function routes(Router $router): void
    {
        $router->middleware([$this->getController(), 'authorization'],
            $router->get(NativeRoutes::ADMIN_PAGES_MANAGER, [$this->getController(), 'index']),
        );

        /**
         * Pages manager routes
         */
        $router->middleware([$this->getApiController(), 'authorization'],
            $router->post(NativeRoutes::ADMIN_API_PAGE_STRUCTURE_EDIT, [$this->getApiController(), 'editContentOfBlock']),
            $router->post(NativeRoutes::ADMIN_API_PAGE_STRUCTURE_ADD_BLOCK, [$this->getApiController(), 'addBlockToPage']),
            $router->post(NativeRoutes::ADMIN_API_PAGE_STRUCTURE_DELETE_BLOCK, [$this->getApiController(), 'deleteStructureOfPage']),
            $router->post(NativeRoutes::ADMIN_API_PAGE_STRUCTURE_BLOCK_MOVE_TO_UP, [$this->getApiController(), 'moveStructureOfPageToUp']),
            $router->post(NativeRoutes::ADMIN_API_PAGE_STRUCTURE_BLOCK_MOVE_TO_DOWN, [$this->getApiController(), 'moveStructureOfPageToDown']),
        );
    }
}