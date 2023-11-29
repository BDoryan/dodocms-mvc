<?php

Autoloader::require('core/controllers/DOMController.php');
Autoloader::require('core/controllers/AdminController.php');

class ResourcesManagerController extends PanelController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $resources = ResourceModel::findAll("*", [], "createdAt DESC");
        $this->viewSection("resources/index", ["resources" => $resources]);
    }
}