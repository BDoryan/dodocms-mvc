<?php
Header::create()
    ->template('/core/ui/views/admin/components')
    ->title(__('admin.panel.configuration.title'))
    ->description(__('admin.panel.configuration.description'))
    ->content(
        Button::create()
            ->green()
            ->text('<i class="tw-me-1 fa-solid fa-plus-circle"></i> ' . __('admin.panel.configuration.new'))
            ->attribute('v-on:click', '')
//            ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_USERS_MANAGER_NEW))
            ->html()
    )
    ->render();

TableComponent::create()
    ->columns($columns ?? [])
    ->rows($rows ?? [])
    ->render();
?>