<?php

Autoloader::require('core/classes/controller/DOMController.php');
Autoloader::require('core/controllers/AdminController.php');

class UsersController extends SectionController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $users = UserModel::findAll("*", [], "createdAt DESC");

        $attributes = ['email', 'username', 'createdAt', 'updatedAt'];

        $columns = [...$attributes, __("admin.panel.tables.table.entries.actions")];
        $rows = [];

        foreach ($users as $entry) {
            $row = $entry->toArray();
            $row = array_map(function ($value) {
                $value = htmlspecialchars($value);
                if (strlen($value) > 50) {
                    $value = substr($value, 0, 50) . "...";
                }
                return $value;
            }, $row);

//            $edit = ButtonHypertext::create()
//                ->text('<i class="tw-me-1 fa-solid fa-pen-to-square"></i> ' . __("admin.panel.tables.table.entries.actions.edit"))
//                ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_TABLE_EDIT_ENTRY, ["table" => $table_name, "id" => $entry['id']]))
//                ->addClass("tw-text-sm tw-whitespace-nowrap")
//                ->blue()
//                ->html();

//            $delete = ButtonHypertext::create()
//                ->text('<i class="tw-me-1 fa-solid fa-trash"></i> ' . __("admin.panel.tables.table.entries.actions.delete"))
//                ->addClass("tw-text-sm tw-whitespace-nowrap")
//                ->red()
//                ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_TABLE_DELETE_ENTRY, ["table" => $table_name, "id" => $entry['id']]))
//                ->html();

//            $row[] = '<div class="tw-flex tw-flex-row tw-justify-center align-center tw-gap-3">' . "$edit $delete" . '</div>';
            $rows[] = $row;
        }

        $this->viewSection("users", [
            'columns' => $columns,
            'rows' => $rows
        ]);
    }
}