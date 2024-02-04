<?php


Header::create()
    ->template('/core/ui/views/admin/components')
    ->title(__('admin.panel.resources.title'))
    ->description(__('admin.panel.resources.description'))
//    ->content(
//        '<div class="tw-flex tw-flex-row">' .
//        Button::create()
//            ->blue()
//            ->attribute('v-on:click', "openModal")
//            ->text('<i class="fa-solid fa-cloud-upload tw-me-1"></i> ' . __('admin.panel.dashboard.button.upload_file'))
//            ->html()
//        . '</div>'
//    )
    ->render();
?>
<!--<resources :resources="--><?php //= Tools::parseJsonToHtmlAttribute(json_encode($resources ?? [], JSON_HEX_QUOT)) ?><!--"></resources>-->
<resource-viewer :deletable="true" :editable="true"  :addable="false" :removable="false" :uploadable="true" :selectable="false"
                 :items="<?= Tools::parseJsonToHtmlAttribute(json_encode($resources ?? [], JSON_HEX_QUOT)) ?>"></resource-viewer>
<modal-upload @resourceUploaded="addResource" @finishUpload="" :multiple="true"></modal-upload>