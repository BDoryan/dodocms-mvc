<?php

class DefaultApiController extends ApiController
{

    public function __construct()
    {
    }

    public function checkAuthorization(): bool
    {
        try {
            if (Session::authenticated()) return true;
            $this->error("unauthorized");
        } catch (Exception $e) {
            $this->error("authorization_check_error");
            Application::get()->getLogger()->error('Error while checking authorization: ' . $e->getMessage());
        }
        return false;
    }

    public function notFound()
    {
        $this->error("route_not_found");
    }
}