<?php
ButtonHypertext::create()
    ->href(Tools::getCurrentURI(false))
    ->text('<i class="tw-me-1 fa-solid fa-solid-xmark"></i> ' . __("admin.panel.tables.table.entries.actions.cancel"))
    ->addClass("tw-w-full")
    ->gray()
    ->render();
