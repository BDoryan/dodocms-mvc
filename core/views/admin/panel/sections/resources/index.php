<?php $modal = "uploadModal" ?>
<?php
Header::create()
    ->template('/core/views/admin/components')
    ->title(__('admin.panel.resources.title'))
    ->description(__('admin.panel.resources.description'))
    ->content(
        '<div class="dodocms-flex dodocms-flex-row dodocms-p-3 ">' .
        Button::create()
            ->blue()
            ->attribute("onclick", "openUploadModal(true)")
            ->text('<i class="dodocms-me-1 fa-solid fa-cloud-upload dodocms-me-1"></i> ' . __('admin.panel.dashboard.button.upload_file'))
            ->html() /*.
        ButtonHypertext::create()
            ->blue(600, true)
            ->text('<i class="dodocms-me-1 fa-solid fa-folder-plus dodocms-me-1"></i> ' . __('admin.panel.dashboard.button.new_folder'))
            ->href(Routes::route(Routes::ADMIN_TABLES_NEW))
            ->html()*/
        . '</div>'
    )
    ->render();
view(Application::get()->toRoot("core/views/admin/components/resources/upload.php"), ["var" => $modal]);
?>
<div class="resources-container dodocms-py-5 dodocms-bg-gray-600 dodocms-p-4 dodocms-rounded-xl dodocms-border-[1px] dodocms-border-gray-500 dodocms-shadow-lg dodocms-flex dodocms-flex-col dodocms-flex-wrap"
     x-data="{ resourceTarget: null }">
    <?php if (empty($resources)) { ?>
        <span class="dodocms-m-auto dodocms-text-gray-300 dodocms-text-2xl italic"><?= __('admin.panel.resources.empty') ?></span>
    <?php } else { ?>
        <h1 class="dodocms-text-count dodocms-text-2xl dodocms-uppercase dodocms-font-bold dodocms-w-full dodocms-p-2 pt-0"><?= __('admin.panel.resources.count', ['count' => count($resources)]) ?></h1>
        <div class="resources-items dodocms-flex dodocms-flex-row dodocms-flex-wrap">
            <?php foreach ($resources as $resource) { ?>
                <div class="resource-item dodocms-p-2 dodocms-w-4/12">
                    <?php view(Application::get()->toRoot("core/views/admin/components/resources/resource.php"), ["resource" => $resource]) ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
