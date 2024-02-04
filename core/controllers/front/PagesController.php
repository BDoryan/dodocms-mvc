<?php

use HeadlessChromium\BrowserFactory;

Autoloader::require('core/classes/controller/DOMController.php');
Autoloader::require('core/controllers/AdminController.php');

class PagesController extends SectionController
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
        $pages = PageModel::findAll("*", [], "createdAt DESC");

        $attributes = ['name', 'seo_title', 'seo_description', 'keywords', 'slug', 'updatedAt'];
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

            $view = ButtonHypertext::create()
                ->text('<i class="tw-me-1 fa-solid fa-eye"></i> ' . __("admin.panel.pages.view"))
                ->addClass("tw-text-sm tw-whitespace-nowrap")
                ->green()
                ->href(
                    $entry->getSlug().'?editor=true'
                )
                ->target("_blank")
                ->html();

            $delete = ButtonHypertext::create()
                ->text('<i class="tw-me-1 fa-solid fa-trash"></i> ' . __("admin.panel.tables.table.entries.actions.delete"))
                ->addClass("tw-text-sm tw-whitespace-nowrap")
                ->red()
                ->href(
                    DefaultRoutes::route(
                        DefaultRoutes::ADMIN_TABLE_DELETE_ENTRY, [
                            "table" => PageModel::TABLE_NAME,
                            "id" => $entry->getId()
                        ]
                    ) . '?redirection=' . Tools::getEncodedCurrentURI()
                )
                ->html();

            $row['admin.panel.tables.table.entries.actions'] = '<div class="tw-flex tw-flex-row tw-justify-center align-center tw-gap-3">' . "$view $edit $delete" . '</div>';
            $rows[] = $row;
        }

        $model = new PageModel();
        $entry_id = $_GET['entry_id'] ?? null;
        if ($entry_id != null) {
            $model->id(intval($entry_id));
            if (!$model->fetch())
                throw new Exception('Entry not found');
        }

        $this->viewSection("pages", [
            'columns' => $columns,
            'rows' => $rows,
            'model' => $model
        ]);
    }
}