<?php

Autoloader::require('core/classes/router/Routable.php');

abstract class Routes implements Routable
{

    protected ?AdminController $controller;
    protected ?ApiAdminController $apiController;

    public function __construct(?Controller $controller = null, ?ApiController $apiController = null)
    {
        $this->controller = $controller;
        $this->apiController = $apiController;
    }

    /**
     * Return the API controller of the section
     *
     * @return ApiController
     */
    public function getApiController(): ?ApiController
    {
        return $this->apiController;
    }

    /**
     * Return the controller of the section
     *
     * @return Controller
     */
    public function getController(): ?Controller
    {
        return $this->controller;
    }

}