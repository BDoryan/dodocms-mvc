<?php

class ConfigurationSection extends Section
{

    public function __construct()
    {
        parent::__construct(new ConfigurationController());
    }

    public function routes(Router $router): void
    {
        $router->middleware([$this->getController(), 'authorization'],
            $router->get(DefaultRoutes::ADMIN_CONFIGURATION, [$this->getController(), 'index']),
        );
    }
}