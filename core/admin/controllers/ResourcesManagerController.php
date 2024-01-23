<?php

Autoloader::require('core/controllers/DOMController.php');
Autoloader::require('core/admin/controllers/AdminController.php');

class ResourcesManagerController extends PanelController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $resources = ResourceModel::findAll("*", [], "createdAt DESC");
        /** @var ResourceModel $resource */
        $resources = array_map(function ($resource) {
            $resource_data = $resource->toArray();
            $resource_data['src'] = $resource->getURL();
            return $resource_data;
        }, $resources);
//        $page = $_GET['page'] - 1 ?? 0;
//        $resources = array_slice($resources, 12 * $page, 12);

        $this->viewSection("resources/index", ["resources" => $resources]);
    }

    public function getResource(array $params = [])
    {
        $resource = new ResourceModel();
        if ($resource->id($params["id"])->fetch() === false) {
            echo "Resource Not Found 404";
            return;
        }
        view(Application::get()->toRoot("core/ui/views/admin/components/resources/resources-selector-item.php"), ["resource" => $resource]);
    }
}