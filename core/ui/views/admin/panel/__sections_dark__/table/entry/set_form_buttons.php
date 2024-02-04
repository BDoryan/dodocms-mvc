<?php
view(Application::get()->toRoot("/core/ui/views/admin/panel/sections/table/entry/set_form_button_entries_back.php"), [
    'table_name' => $table_name ?? '',
]);
view(Application::get()->toRoot("/core/ui/views/admin/panel/sections/table/entry/set_form_button_submit.php"), [
    'entry_id' => $entry_id ?? null,
]);
