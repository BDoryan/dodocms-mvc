<?php

class HelloWorldRoutes extends ModuleSection
{

    public function __construct(Module $module)
    {
        parent::__construct($module, new HelloWorldController($module));
    }

    public function routes(Router $router): void
    {
        $router->middleware([$this->getController(), 'authorization'],
            $router->get(DefaultRoutes::ADMIN_PANEL."/test", [$this->getController(), 'index'])
        );
    }
}