<?php

Header::create()
    ->template('/core/ui/views/admin/components')
    ->title(__('admin.panel.block_manager'))
    ->description(__('admin.panel.block_manager.description'))
    ->content(
        ButtonHypertext::create()
            ->green()
            ->text('<i class="tw-me-1 fa-solid fa-plus-circle"></i> ' . __('admin.panel.blocks.new'))
            ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_USERS_MANAGER_NEW))
            ->html()
    )
    ->render();

?>
<p class="tw-gray-200 tw-opacity-75 tw-italic">En cours de développement...</p>
