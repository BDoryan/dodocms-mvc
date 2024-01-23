<?php

class UsersSection extends Section
{

    public function __construct()
    {
        parent::__construct(new UsersController());
    }

    public function routes(Router $router): void
    {
        $router->middleware([$this->getController(), 'authorization'],
            $router->get(DefaultRoutes::ADMIN_USERS, [$this->getController(), 'index']),
        );
    }
}