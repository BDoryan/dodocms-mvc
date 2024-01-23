<?php

class ApiAdminController extends ApiController {

    /**
     * Check if the user is authorized to access the API
     *
     * @return bool
     */
    public function authorization(): bool
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
}