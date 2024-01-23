<?php

Autoloader::require('core/classes/controller/DOMController.php');
Autoloader::require('core/admin/controllers/AdminController.php');

class ConfigurationController extends SectionController
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