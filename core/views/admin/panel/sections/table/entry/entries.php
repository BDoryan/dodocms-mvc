<?php
Header::create()
    ->template('/core/views/admin/components')
    ->title(__('admin.panel.tables.table.entries.title', ["table" => $table_name ?? 'empty_table_name']))
    ->description(__('admin.panel.tables.table.entries.description', ["table" => $table_name ?? 'empty_table_name']))
    ->content(
        ButtonHypertext::create()
            ->green()
            ->text('<i class="fa-solid fa-plus"></i> ' . __('admin.panel.tables.table.entries.button.new_entry'))
            ->href(Routes::route(Routes::ADMIN_TABLES_NEW))
            ->html()
    )
    ->render();

if(!empty($columns)) {
    TableComponent::create()
        ->columns($columns)
        ->rows($rows ?? [])
        ->render();
}