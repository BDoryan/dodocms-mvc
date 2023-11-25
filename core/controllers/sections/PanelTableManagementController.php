<?php

Autoloader::require("core/controllers/PanelController.php");
Autoloader::require("core/classes/database/table/Table.php");

class PanelTableManagementController extends PanelController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function tables(array $params): void
    {
        Application::get()->getLogger()->debug("PanelTableManagementController->tables(" . (var_export($params, true)) . ")");
        $tables = Table::getTables();

        $this->addContent(Toast::create()->type(Toast::TYPE_SUCCESS)->title("Je test mon title")->message("Table créée avec succès")->html());

        $this->viewSection("table/tables", ["tables" => $tables]);
    }

    public function new(array $params): void
    {
        $this->set([
            'title' => __("admin.panel.tables.table.new.title"),
            'description' => __("admin.panel.tables.table.new.description")
        ]);
    }

    public function edit(array $params): void
    {
        $table = $params['table'];
        $this->set([
            'title' => __("admin.panel.tables.table.edit.title", ['table' => $table]),
            'description' => __("admin.panel.tables.table.edit.description")
        ]);
    }

    public function set(array $data = []): void
    {
        $data['table'] = null;
        $this->viewSection("table/set", $data);
    }
}