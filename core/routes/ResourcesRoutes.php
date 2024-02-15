<?php

class ResourcesRoutes extends Section
{

    public function __construct()
    {
        parent::__construct(new ResourcesController(), new ApiResourcesController());
    }

    public function routes(Router $router): void
    {
        $router->middleware([$this->getController(), 'authorization'],
            $router->get(NativeRoutes::ADMIN_RESOURCES_MANAGER, [$this->getController(), 'index']),
            $router->get(NativeRoutes::ADMIN_API_GET_HTML_RESOURCE, [$this->getController(), 'getResource']),
        );

        $router->middleware([$this->getApiController(), 'authorization'],
            $router->post(NativeRoutes::ADMIN_API_UPLOAD_RESOURCE, [$this->getApiController(), "upload"]),
            $router->put(NativeRoutes::ADMIN_API_EDIT_RESOURCE, [$this->getApiController(), "edit"]),
            $router->delete(NativeRoutes::ADMIN_API_DELETE_RESOURCE, [$this->getApiController(), "delete"]),
            $router->get(NativeRoutes::ADMIN_API_GET_RESOURCE, [$this->getApiController(), "get"]),
            $router->get(NativeRoutes::ADMIN_API_GET_RESOURCES, [$this->getApiController(), "all"])
        );
    }
}