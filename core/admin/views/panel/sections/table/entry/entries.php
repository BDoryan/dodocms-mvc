<?php

Header::create()
    ->template('/core/admin/views/components')
    ->title(__('admin.panel.tables.table.entries.title', ["table" => $table_name ?? 'empty_table_name']))
    ->description(__('admin.panel.tables.table.entries.description', ["table" => $table_name ?? 'empty_table_name']))
    ->content(
        ButtonHypertext::create()
            ->green()
            ->text('<i class="dodocms-me-1 fa-solid fa-plus-circle"></i> ' . __('admin.panel.tables.table.entries.button.new_entry'))
            ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_TABLE_NEW_ENTRY, ['table' => $table_name ?? 'empty_table_name']))
            ->html()
    )
    ->render();

if(!empty($columns)) {
    TableComponent::create()
        ->columns($columns)
        ->rows($rows ?? [])
        ->render();
}