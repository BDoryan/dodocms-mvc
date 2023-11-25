<?php
if (empty($title)) $title = "";
if (empty($description)) $description = "";

Header::create()
    ->template('/core/views/admin/components')
    ->title($title)
    ->description($description)
    ->render();