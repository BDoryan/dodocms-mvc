<?php




Header::create()
    ->template('/core/admin/views/components')
    ->title(__('admin.panel.users.title'))
    ->description(__('admin.panel.users.description'))
    ->content(
        ButtonHypertext::create()
            ->green()
            ->text('<i class="dodocms-me-1 fa-solid fa-plus-circle"></i> ' . __('admin.panel.users.new'))
            ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_USERS_MANAGER_NEW))
            ->html()
    )
    ->render();

?>
<p class="dodocms-gray-200 dodocms-opacity-75 dodocms-italic">En cours de développement...</p>
