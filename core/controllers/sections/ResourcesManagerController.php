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

    public function getResource(array $params = []) {
        $resource = new ResourceModel();
        if($resource->id($params["id"])->fetch() === false) {
            echo "Resource Not Found 404";
            return;
        }
        view(Application::get()->toRoot("core/views/admin/components/resources/resources-selector-item.php"), ["resource" => $resource]);
    }
}