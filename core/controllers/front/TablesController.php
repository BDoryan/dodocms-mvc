<?php

Autoloader::require("core/controllers/PanelController.php");
Autoloader::require("core/classes/database/table/Table.php");
Autoloader::require("core/classes/database/table/model/Model.php");
Autoloader::require("core/ui/components/alert/Alert.php");

class TablesController extends SectionController
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

    private function getTable($table_name): Table
    {
        $table = Table::getTable($table_name);
        if (!isset($table)) {
            $this->addToast(new Toast(__("admin.panel.toast.error"), __("admin.panel.tables.table.not_found", ["table" => $table_name]), Toast::TYPE_ERROR));
            header("Location: " . DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES));
            exit;
        }
        return $table;
    }

    private function getModel(Table $table): Model
    {
        $model = Model::getModel($table);
        if (!isset($model)) {
            $this->addToast(new Toast(__("admin.panel.toast.error"), __("admin.panel.tables.table.model_not_found", ["model" => $table->getName()]), Toast::TYPE_ERROR));
            header('Location: ' . DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES_TABLE_ENTRIES, ["table" => $table->getName()]));
            exit;
        }
        return $model;
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

    public function attribute(): void
    {
        // With this method, we can use a view without the layout
        view(Application::get()->toRoot("/core/ui/views/admin/panel/sections/table/attribute/attribute.php"));
    }

    public function delete(array $params): void
    {
        $table_name = $params['table'];
        $table = $this->getTable($table_name);
        if (!empty($table)) {
            $table->destroy();
            $this->addToast(new Toast(__("admin.panel.toast.success"), __("admin.panel.tables.table.delete.success", ["table" => $table_name]), Toast::TYPE_SUCCESS));
            Application::get()->getRouter()->redirect(DefaultRoutes::ADMIN_TABLES);
            exit;
        }
        $this->addToast(new Toast(__("admin.panel.toast.error"), __("admin.panel.tables.table.not_found", ["table" => $table_name]), Toast::TYPE_ERROR));
        header("Location: " . DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES));
        exit;
    }

    public function getEntries(string $table_name): array
    {
        $table = Table::getTable($table_name);
        if (empty($table)) {
            $this->addToast(new Toast(__("admin.panel.toast.error"), __("admin.panel.tables.table.not_found", ["table" => $table_name]), Toast::TYPE_ERROR));
            header("Location: " . DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES));
            exit;
        }

        $attributes = array_map(function ($attribute) {
            return $attribute->getName();
        }, $table->getAttributes());

        $entries = $table->findAll();

        $columns = [...$attributes, "admin.panel.tables.table.entries.actions"];
        $rows = [];
        foreach ($entries as $entry) {
            $row = array_map(function ($value) {
                $value = htmlspecialchars($value ?? '');
                if (strlen($value) > 50) {
                    $value = substr($value, 0, 50) . "...";
                }
                return $value;
            }, $entry);

            $edit = ButtonHypertext::create()
                ->text('<i class="tw-me-1 fa-solid fa-pen-to-square"></i> ' . __("admin.panel.tables.table.entries.actions.edit"))
                ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_TABLE_EDIT_ENTRY, ["table" => $table_name, "id" => $entry['id']]))
                ->addClass("tw-text-sm tw-whitespace-nowrap")
                ->blue()
                ->html();

            $delete = ButtonHypertext::create()
                ->text('<i class="tw-me-1 fa-solid fa-trash"></i> ' . __("admin.panel.tables.table.entries.actions.delete"))
                ->addClass("tw-text-sm tw-whitespace-nowrap")
                ->red()
                ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_TABLE_DELETE_ENTRY, ["table" => $table_name, "id" => $entry['id']]))
                ->html();

            $row['admin.panel.tables.table.entries.actions'] = '<div class="tw-flex tw-flex-row tw-justify-center align-center tw-gap-3">' . "$edit $delete" . '</div>';
            $rows[] = $row;
        }

        return [
            'table_name' => $table_name,
            'columns' => $columns,
            'rows' => $rows
        ];
    }

    public function entries($params)
    {
        $table_name = $params['table'];
        $entriesData = $this->getEntries($table_name);

        $this->viewSection('table/entry/entries', $entriesData);
    }

    public function deleteEntry(array $params): void
    {
        $table_name = $params['table'];
        $entry_id = $params['id'];

        $table = $this->getTable($table_name);
        $model = $this->getModel($table);

        $redirection = $_GET['redirection'] ?? '';

        try {
            if ($model->id($entry_id)->fetch() == null) {
                $this->addToast(new Toast(__("admin.panel.toast.error"), __("admin.panel.tables.table.entries.entry_not_found", ["table" => $table_name, "entry_id" => $entry_id]), Toast::TYPE_ERROR));
            } else {
                if ($model->delete()) {
                    $this->addToast(new Toast(__("admin.panel.toast.success"), __("admin.panel.tables.table.entries.delete_entry.success"), Toast::TYPE_SUCCESS));
                } else {
                    Application::get()->getLogger()->error("Error while deleting entry");
                    $this->addAlert(new Alert(__("admin.panel.toast.error"), __("admin.panel.tables.table.entries.delete_entry.error"), Toast::TYPE_ERROR));
                }
                if(!empty($redirection)) {
                    Application::get()->redirect(urldecode($redirection));
                    exit;
                }
            }
        } catch (Exception $e) {
            Application::get()->getLogger()->error("Error while deleting entry");
            Application::get()->getLogger()->printException($e);
            $this->addAlert(new Alert(__("admin.panel.toast.error"), __("admin.panel.tables.table.entries.delete_entry.error"), Toast::TYPE_ERROR));
        }
        Application::get()->redirect(DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES_TABLE_ENTRIES, ["table" => $table_name]));
    }

    public function newEntry(array $params): void
    {
        $this->setEntry($params);
    }

    public function editEntry(array $params)
    {
        $this->setEntry($params);
    }

    public function setEntry(array $params)
    {
        $data = [];

        $table_name = $params['table'];
        $table = $this->getTable($table_name);
        $model = $this->getModel($table);

        $entry_id = $params['id'] ?? null;

        try {
            if (isset($entry_id)) {
                if ($model->id($entry_id)->fetch() == null) {
                    $this->addToast(new Toast(__("admin.panel.toast.error"), __("admin.panel.tables.table.entries.entry_not_found", ["table" => $table_name, "entry_id" => $entry_id]), Toast::TYPE_ERROR));
                    header('Location: ' . DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES_TABLE_ENTRIES, ["table" => $table_name]));
                    exit;
                }
            }

            $redirection = $_GET['redirection'] ?? '';
            $post_data = array_slice($_POST, 0);

            if (!empty($post_data)) {
                if (isset($entry_id))
                    $model->id($entry_id);

                $model->hydrate($post_data);
                if (isset($entry_id) ? $model->update() : $model->create()) {
                    $this->addToast(new Toast(__("admin.panel.toast.success"), isset($entry_id) ? __("admin.panel.tables.table.entries.edit_entry.success") : __("admin.panel.tables.table.entries.create_entry.success"), Toast::TYPE_SUCCESS));
                    if(empty($redirection)) {
                        $redirection =
                            isset($entry_id)
                                ? DefaultRoutes::getRoute(DefaultRoutes::ADMIN_TABLES_TABLE_ENTRIES, ["table" => $table_name])
                                : DefaultRoutes::getRoute(DefaultRoutes::ADMIN_TABLE_EDIT_ENTRY, ["table" => $table_name, "id" => $entry_id]);
                    } else {
                        $redirection = urldecode($redirection);
                    }
                    Application::get()->redirect($redirection);
                    exit;
                } else {
                    Application::get()->getLogger()->error("Error while setting entry");
                    $this->addAlert(new Alert(__("admin.panel.toast.error"), isset($entry_id) ? __("admin.panel.tables.table.entries.edit_entry.error") : __("admin.panel.tables.table.entries.create_entry.error"), Toast::TYPE_ERROR));
                }
            }
        } catch (Exception $e) {
            Application::get()->getLogger()->error("Error while setting entry");
            Application::get()->getLogger()->error('params => ' . print_r($params, true));
            Application::get()->getLogger()->error('data => ' . print_r($_POST, true));
            Application::get()->getLogger()->printException($e);
            $this->addAlert(new Alert(__("admin.panel.toast.error"), isset($entry_id) ? __("admin.panel.tables.table.entries.edit_entry.error") : __("admin.panel.tables.table.entries.create_entry.error"), Toast::TYPE_ERROR));
        }


        $data['table'] = $table;
        $data['table_name'] = $table_name;
        $data['model'] = $model;
        $data['entry_id'] = $entry_id;
        $data['buttons'] = fetch(Application::get()->toRoot("/core/ui/views/admin/panel/sections/table/entry/set_form_buttons.php"), $data);

        $this->viewSection('table/entry/set', $data);
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
                    $this->addToast(new Toast(__("admin.panel.toast.error"), __("admin.panel.tables.table.set.error.invalid_json"), Toast::TYPE_ERROR));
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
                        $this->addAlert(new Alert(__("admin.panel.toast.error"), __("admin.panel.tables.table.set.error.sql", ["table" => $post_table->getName(), "error" => $e->getMessage()]), Toast::TYPE_ERROR));
                    }
                }
            }
        }

        $data['table'] = $table;
        $this->viewSection("table/set", $data);
    }
}