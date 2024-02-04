<?php
ButtonHypertext::create()
    ->href(Tools::getCurrentURI(false))
    ->text('<i class="tw-me-1 fa-solid fa-arrow-left"></i> ' . __("admin.panel.tables.table.entries.actions.back"))
    ->addClass("tw-w-full")
    ->gray()
    ->render();
