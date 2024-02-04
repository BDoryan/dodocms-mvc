<?php
ButtonHypertext::create()
    ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES_TABLE_ENTRIES, ["table" => $table_name ?? '']))
    ->text('<i class="tw-me-1 fa-solid fa-circle-left"></i> ' . __("admin.panel.tables.table.entries.back"))
    ->addClass("tw-w-full")
    ->blue()
    ->render();
