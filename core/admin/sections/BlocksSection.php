<?php

class BlocksSection extends Section
{

    public function __construct()
    {
        parent::__construct(new ResourcesController(), new ApiResourcesController());
    }

    public function routes(Router $router): void
    {

    }
}