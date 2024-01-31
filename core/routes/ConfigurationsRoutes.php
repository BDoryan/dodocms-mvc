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
            $router->get(DefaultRoutes::ADMIN_CONFIGURATION, [$this->getController(), 'index']),
            $router->post(DefaultRoutes::ADMIN_CONFIGURATION, [$this->getController(), 'index']),
        );
    }
}