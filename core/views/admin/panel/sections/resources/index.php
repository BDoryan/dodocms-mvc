<?php $modal = "uploadModal" ?>
<div x-data="{ <?= $modal ?>: { show: false, multiple: false } }">
    <?php
    Header::create()
        ->template('/core/views/admin/components')
        ->title(__('admin.panel.resources.title'))
        ->description(__('admin.panel.resources.description'))
        ->content(
            '<div class="flex flex-row gap-3 ">' .
            Button::create()
                ->blue()
                ->attribute("@click", "uploadModal.show = true")
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
<div class="resources-container py-5 bg-gray-600 p-4 rounded-xl border-[1px] border-gray-500 shadow-lg flex flex-col flex-wrap" x-data="{ resourceTarget: null }">
    <?php if(empty($resources)) { ?>
        <span class="m-auto text-gray-300 text-2xl italic"><?= __('admin.panel.resources.empty') ?></span>
    <?php } else { ?>
        <h1 class="resources-text-count text-2xl uppercase font-bold w-full p-2 pt-0"><?= __('admin.panel.resources.count', ['count' => count($resources)]) ?></h1>
        <div class="resources-items flex flex-row flex-wrap">
            <?php foreach ($resources as $resource) { ?>
                <div class="resource-item p-2 w-4/12">
                    <?php view(Application::get()->toRoot("core/views/admin/components/resources/resource.php"), ["resource" => $resource]) ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
