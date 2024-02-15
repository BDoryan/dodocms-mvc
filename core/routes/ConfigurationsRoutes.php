<?php

class ConfigurationsRoutes extends Section
{

    public function __construct()
    {
        parent::__construct(new ConfigurationsController());
    }

    public function routes(Router $router): void
    {
        $router->middleware([$this->getController(), 'authorization'],
            $router->get(NativeRoutes::ADMIN_CONFIGURATION, [$this->getController(), 'index']),
            $router->post(NativeRoutes::ADMIN_CONFIGURATION, [$this->getController(), 'index']),
        );
    }
}