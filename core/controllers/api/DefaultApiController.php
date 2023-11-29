<?php

class DefaultApiController extends ApiController
{

    public function __construct()
    {
    }

    public function notFound() {
        $this->error("route_not_found");
    }
}