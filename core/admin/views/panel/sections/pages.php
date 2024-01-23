<?php

Header::create()
    ->template('/core/admin/views/components')
    ->title(__('admin.panel.pages.title'))
    ->description(__('admin.panel.pages.description'))
    ->content(
        ButtonHypertext::create()
            ->green()
            ->text('<i class="dodocms-me-1 fa-solid fa-plus-circle"></i> ' . __('admin.panel.pages.new'))
            ->href(Routes::route(Routes::ADMIN_USERS_MANAGER_NEW))
            ->html()
    )
    ->render();

?>
<p class="dodocms-gray-200 dodocms-opacity-75 dodocms-italic">En cours de développement...</p>
