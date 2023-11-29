<?php $modal = "showUploadModal" ?>
<div x-data="{ <?= $modal ?>: false }">
    <?php
    Header::create()
        ->template('/core/views/admin/components')
        ->title(__('admin.panel.resources.title'))
        ->description(__('admin.panel.resources.description'))
        ->content(
            '<div class="flex flex-row gap-3 ">' .
            Button::create()
                ->blue()
                ->attribute("@click", "showUploadModal = true")
                ->text('<i class="me-1 fa-solid fa-cloud-upload me-1"></i> ' . __('admin.panel.dashboard.button.upload_file'))
                ->html() /*.
        ButtonHypertext::create()
            ->blue(600, true)
            ->text('<i class="me-1 fa-solid fa-folder-plus me-1"></i> ' . __('admin.panel.dashboard.button.new_folder'))
            ->href(Routes::route(Routes::ADMIN_TABLES_NEW))
            ->html()*/
            . '</div>'
        )
        ->render();
    view(Application::get()->toRoot("core/views/admin/components/resources/upload.php"), ["var" => $modal]);
    ?>
</div>
