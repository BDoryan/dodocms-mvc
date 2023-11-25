<?php
Header::create()
    ->template('/core/views/admin/components')
    ->title(__('admin.panel.table_management'))
    ->description(__('admin.panel.table_management.description'))
    ->content(
        ButtonHypertext::create()
            ->green()
            ->text('<i class="fa-solid fa-plus"></i> ' . __('admin.panel.dashboard.button.new_table'))
            ->href(Routes::route(Routes::ADMIN_TABLES_NEW))
            ->html()
    )
    ->render();
?>
