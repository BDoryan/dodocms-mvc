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
view(Application::get()->toRoot("core/views/admin/components/resources/upload-modal.php"), ["var" => $modal]);
?>
<?php //= Tools::parseJsonToHtmlAttribute(json_encode($resources ?? [], JSON_HEX_QUOT)) ?>
<resource-viewer :deletable="true" :editable="true" :selectable="false" :items="<?= Tools::parseJsonToHtmlAttribute(json_encode($resources ?? [], JSON_HEX_QUOT)) ?>"></resource-viewer>