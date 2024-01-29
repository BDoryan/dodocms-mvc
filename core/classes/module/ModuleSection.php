<?php

Autoloader::require("core/classes/panel/Section.php");

abstract class ModuleSection extends Section
{

    private Module $module;

    public function __construct(Module $module, AdminController $controller = null, ApiAdminController $apiController = null)
    {
        parent::__construct($controller, $apiController);
        $this->module = $module;
    }

    /**
     * @return Module
     */
    public function getModule(): Module
    {
        return $this->module;
    }
}