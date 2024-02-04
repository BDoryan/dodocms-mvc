<?php

Header::create()
    ->template('/core/ui/views/admin/components')
    ->title(__('admin.panel.pages.title'))
    ->description(__('admin.panel.pages.description'))
//    ->content(
//        ButtonHypertext::create()
//            ->green()
//            ->text('<i class="tw-me-1 fa-solid fa-plus-circle"></i> ' . __('admin.panel.pages.new'))
//            ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_USERS_MANAGER_NEW))
//            ->html()
//    )
    ->render();

TableComponent::create()
    ->columns($columns ?? [])
    ->rows($rows ?? [])
    ->render();
?>
<div class="tw-flex tw-wrap tw-mt-5">
    <div class="tw-w-1/2 tw-border-[1px] tw-border-gray-700 tw-border-opacity-25  tw-drop-shadow-md tw-text-gray-600 tw-bg-white tw-bg-opacity-70 tw-rounded-lg tw-p-4">
        <?php
        PageModel::renderForm([
            'action' => DefaultRoutes::route(DefaultRoutes::ADMIN_TABLE_NEW_ENTRY, ['table' => 'Page']).'?redirection='.Tools::getEncodedCurrentURI(),
            'buttons' => fetch(Application::get()->toRoot('/core/ui/views/admin/panel/sections/table/entry/set_form_button_submit'))
        ])
        ?>
    </div>
</div>