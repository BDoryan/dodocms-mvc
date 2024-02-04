<?php
Button::create()
    ->submittable()
    ->text(isset($entry_id) ? '<i class="tw-me-1 fa-solid fa-pen-to-square"></i> ' . __('admin.panel.tables.table.entries.edit_entry.button') : '<i class="tw-me-1 fa-solid fa-plus"></i> ' . __('admin.panel.tables.table.entries.new_entry.button'))
    ->addClass("tw-w-full")
    ->green()
    ->render();
?>
