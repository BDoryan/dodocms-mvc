<?php

class BlocksRoutes extends Section
{

    public function __construct()
    {
        parent::__construct(new BlocksController());
    }

    public function routes(Router $router): void
    {
        $router->middleware([$this->getController(), 'authorization'],
            $router->get(DefaultRoutes::ADMIN_BLOCKS_MANAGER, [$this->getController(), 'index'])
        );
    }
}