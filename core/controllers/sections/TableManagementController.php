<?php

Autoloader::require("core/controllers/PanelController.php");
Autoloader::require("core/classes/database/table/Table.php");
Autoloader::require("core/components/alert/Alert.php");

class TableManagementController extends PanelController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function tables(array $params): void
    {
        Application::get()->getLogger()->debug("TableManagementController->tables(" . (var_export($params, true)) . ")");
        $tables = Table::getTables();

        $this->viewSection("table/tables", ["tables" => $tables]);
    }

    private function getTable($table_name)
    {
        $table = Table::getTable($table_name);
        if (!isset($table)) {
            $this->addToast(new Toast(__("admin.panel.toast.error"), __("admin.panel.tables.table.not_found", ["table" => $table_name]), Toast::TYPE_DANGER));
            header("Location: " . Routes::route(Routes::ADMIN_TABLES));
            exit;
        }
        return $table;
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
        $table_name = $params['table'];
        $table = $this->getTable($table_name);

        $data = [
            'table' => $table ?? null,
            'table_name' => $table_name ?? null,
            'title' => __("admin.panel.tables.table.edit.title", ['table' => $table_name]),
            'description' => __("admin.panel.tables.table.edit.description")
        ];

        $this->set($data);
    }

    public function attribute()
    {
        // With this method, we can use a view without the layout
        view(Application::get()->toRoot("/core/views/admin/panel/sections/table/attribute/attribute.php"));
    }

    public function delete(array $params): void
    {
        $table_name = $params['table'];
        $table = $this->getTable($table_name);
        if (!empty($table)) {
            $table->destroy();
            $this->addToast(new Toast(__("admin.panel.toast.success"), __("admin.panel.tables.table.delete.success", ["table" => $table_name]), Toast::TYPE_SUCCESS));
            Application::get()->getRouter()->redirect(Routes::ADMIN_TABLES);
            exit;
        }
        $this->addToast(new Toast(__("admin.panel.toast.error"), __("admin.panel.tables.table.not_found", ["table" => $table_name]), Toast::TYPE_DANGER));
        header("Location: " . Routes::route(Routes::ADMIN_TABLES));
        exit;
    }

    public function entries($params)
    {
        $table_name = $params['table'];

        $table = Table::getTable($table_name);
        if (empty($table)) {
            $this->addToast(new Toast(__("admin.panel.toast.error"), __("admin.panel.tables.table.not_found", ["table" => $table_name]), Toast::TYPE_DANGER));
            header("Location: " . Routes::route(Routes::ADMIN_TABLES));
            exit;
        }

        $attributes = array_map(function ($attribute) {
            return $attribute->getName();
        }, $table->getAttributes());

        $entries = $table->findAll();

        $columns = [...$attributes, __("admin.panel.tables.table.entries.actions")];
        $rows = [];
        foreach ($entries as $entry) {
            $row = array_values($entry);
            $row = array_map(function ($value) {
                return strip_tags($value);
            }, $row);

            $edit = ButtonHypertext::create()
                ->text('<i class="fa-solid fa-pen-to-square"></i> ' . __("admin.panel.tables.table.entries.actions.edit"))
                ->href(Routes::route(Routes::ADMIN_TABLE_EDIT_ENTRY, ["table" => $table_name, "id" => $entry['id']]))
                ->addClass("text-sm")
                ->blue()
                ->html();

            $delete = ButtonHypertext::create()
                ->text('<i class="fa-solid fa-trash"></i> ' . __("admin.panel.tables.table.entries.actions.delete"))
                ->addClass("text-sm")
                ->red()
                ->href(Routes::route(Routes::ADMIN_TABLE_DELETE_ENTRY, ["table" => $table_name, "id" => $entry['id']]))
                ->html();

            $row[] = '<div class="flex flex-row justify-center align-center gap-3">' . "$edit $delete" . '</div>';
            $rows[] = $row;
        }

        $this->viewSection('table/entry/entries', [
            'table_name' => $table_name,
            'columns' => $columns,
            'rows' => $rows
        ]);
    }

    public function deleteEntry(array $params) {

    }

    public function newEntry(array $params) {

    }

    public function editEntry(array $params){

    }

    public function setEntry(array $params)
    {
        $this->viewSection('table/entry/set', [
        ]);
    }

    public function set(array $data = []): void
    {
        $table = $data['table'] ?? null;
        if (!empty($_POST)) {
            $post_table_json = $_POST["table_json"] ?? "";

            // Check if a edition data is posted
            if (!empty($post_table_json)) {
                $table_data = json_decode($post_table_json, true);

                $post_table = new Table();
                $post_table->hydrate($table_data);

                // Check if the posted data is valid
                if (empty($table_data) || !isset($table_data['name']) || !isset($table_data['attributes'])) {
                    $this->addToast(new Toast(__("admin.panel.toast.error"), __("admin.panel.tables.table.set.error.invalid_json"), Toast::TYPE_DANGER));
                } else {
                    try {
                        if (empty($table)) {
                            $data['sql'] = $post_table->create();
                            $this->addToast(new Toast(__("admin.panel.toast.success"), __("admin.panel.tables.table.set.success.created", ["table" => $post_table->getName()]), Toast::TYPE_SUCCESS));
//                            header('Location: '. Routes::route(Routes::ADMIN_TABLES_EDIT, ["table" => $post_table->getName()]));
//                            exit;
                        } else {
                            $data['sql'] = $table->update($post_table);
                            $this->addToast(new Toast(__("admin.panel.toast.success"), __("admin.panel.tables.table.set.success.edit", ["table" => $post_table->getName()]), Toast::TYPE_SUCCESS));
//                            header('Location: '. Routes::route(Routes::ADMIN_TABLES_EDIT, ["table" => $post_table->getName()]));
//                            exit;
                        }
                    } catch (SQLException $e) {
                        Application::get()->getLogger()->printException($e);
                        $table = $post_table;
                        $data['sql'] = $e->getSql();
                        $this->addAlert(new Alert(__("admin.panel.toast.error"), __("admin.panel.tables.table.set.error.sql", ["table" => $post_table->getName(), "error" => $e->getMessage()]), Toast::TYPE_DANGER));
                    }
                }
            }
        }

        $data['table'] = $table;
        $this->viewSection("table/set", $data);
    }
}