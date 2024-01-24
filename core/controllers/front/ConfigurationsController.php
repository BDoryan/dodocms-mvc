<?php

Autoloader::require('core/classes/controller/DOMController.php');
Autoloader::require('core/controllers/AdminController.php');

class ConfigurationsController extends SectionController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->viewSection("configuration");
    }
}