<?php

class DefaultApiController extends ApiController
{

    public function __construct()
    {
    }

    public function checkAuthorization(): bool {
        $this->error("unauthorized");
        return false;
    }

    public function notFound() {
        $this->error("route_not_found");
    }
}