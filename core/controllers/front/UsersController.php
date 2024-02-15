<?php

Autoloader::require('core/classes/controller/DOMController.php');
Autoloader::require('core/controllers/AdminController.php');

class UsersController extends SectionController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function index()
    {
        $pages = AdminUserModel::findAll("*", [], "createdAt DESC");

        $attributes = ['username', 'email', 'language', 'updatedAt', 'createdAt'];
        $columns = [...$attributes, 'admin.panel.tables.table.entries.actions'];
        $rows = [];

        foreach ($pages as $entry) {
            $row = $entry->toArray();
            $row = array_map(function ($value) {
                $value = htmlspecialchars($value ?? '');
                if (strlen($value) > 50) {
                    $value = substr($value, 0, 50) . "...";
                }
                return $value;
            }, $row);

            $edit = ButtonHypertext::create()
                ->text('<i class="tw-me-1 fa-solid fa-pen-to-square"></i> ' . __("admin.panel.tables.table.entries.actions.edit"))
                ->href(
                    Tools::getCurrentURI(false) . "?entry_id=" . $entry->getId()
                )
                ->addClass("tw-text-sm tw-whitespace-nowrap")
                ->blue()
                ->html();

            $delete = ButtonHypertext::create()
                ->text('<i class="tw-me-1 fa-solid fa-trash"></i> ' . __("admin.panel.tables.table.entries.actions.delete"))
                ->addClass("tw-text-sm tw-whitespace-nowrap")
                ->red()
                ->href(
                    NativeRoutes::route(
                        NativeRoutes::ADMIN_TABLE_DELETE_ENTRY, [
                            "table" => PageModel::TABLE_NAME,
                            "id" => $entry->getId()
                        ]
                    ) . '?redirection=' . Tools::getEncodedCurrentURI()
                )
                ->html();

            $row['admin.panel.tables.table.entries.actions'] = '<div class="tw-flex tw-flex-row tw-justify-center align-center tw-gap-3">' . "$edit $delete" . '</div>';
            $rows[] = $row;
        }

        $model = new AdminUserModel();
        $entry_id = $_GET['entry_id'] ?? null;
        if ($entry_id != null) {
            $model->id(intval($entry_id));
            if (!$model->fetch())
                throw new Exception('Entry not found');
        }

        $this->viewSection("users", [
            'columns' => $columns,
            'rows' => $rows,
            'model' => $model
        ]);
    }
}