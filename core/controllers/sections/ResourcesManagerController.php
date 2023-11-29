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
//        $resourceModel = new ResourceModel();
//        $resources = $resourceModel->findAll();

        $this->viewSection("resources/index", []);
    }

    public function files() {

    }

    public function uploadFile()
    {
//        $this->section(["section" => "upload"]);
    }
}