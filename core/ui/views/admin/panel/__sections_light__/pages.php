<?php

Header::create()
    ->template('/core/ui/views/admin/components')
    ->title(__('admin.panel.pages.title'))
    ->description(__('admin.panel.pages.description'))
    ->content(
        ButtonHypertext::create()
            ->green()
            ->text('<i class="tw-me-1 fa-solid fa-plus-circle"></i> ' . __('admin.panel.pages.new'))
            ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_USERS_MANAGER_NEW))
            ->html()
    )
    ->render();

TableComponent::create()
    ->columns($columns ?? [])
    ->rows($rows ?? [])
    ->render();
?>
<div class="tw-flex tw-wrap tw-mt-5">
    <div class="tw-w-1/2 tw-bg-gray-800 tw-rounded-lg tw-p-4">
        <?php
        PageModel::renderForm()
        ?>
    </div>
</div>