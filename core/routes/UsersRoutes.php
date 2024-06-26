<?php

class UsersRoutes extends Section
{

    public function __construct()
    {
        parent::__construct(new UsersController());
    }

    public function routes(Router $router): void
    {
        $router->middleware([$this->getController(), 'authorization'],
            $router->get(NativeRoutes::ADMIN_USERS, [$this->getController(), 'index'])
        );
    }
}