<?php

Header::create()
    ->template('/core/ui/views/admin/components')
    ->title(__('admin.panel.configuration.title'))
    ->description(__('admin.panel.configuration.description'))
    ->content(
        ButtonHypertext::create()
            ->green()
            ->text('<i class="dodocms-me-1 fa-solid fa-plus-circle"></i> ' . __('admin.panel.configuration.new'))
            ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_USERS_MANAGER_NEW))
            ->html()
    )
    ->render();

TableComponent::create()
    ->columns($columns ?? [])
    ->rows($rows ?? [])
    ->render();
