<?php

Header::create()
    ->template('/core/ui/views/admin/components')
    ->title(__('admin.panel.pages.title'))
    ->description(__('admin.panel.pages.description'))
    ->render();

TableComponent::create()
    ->columns($columns ?? [])
    ->rows($rows ?? [])
    ->render();
/** @var BlockModel $model */
?>
<div class="tw-flex tw-wrap tw-mt-5 tw-gap-3">
    <div class="tw-w-1/2 tw-border-[1px] tw-border-gray-700 tw-border-opacity-25  tw-drop-shadow-md tw-text-gray-600 tw-bg-white tw-bg-opacity-70 tw-rounded-lg tw-p-4">
        <h2 class="tw-text-lg tw-font-semibold tw-border-b-[1px] tw-border-b-gray-300 tw-mb-2 tw-pb-2"><?= __($model->hasId() ? 'admin.panel.blocks.block.edit' : 'admin.panel.blocks.block.create') ?></h2>
        <?php
        Model::renderForm($model ?? null, [
            'action' => DefaultRoutes::route(DefaultRoutes::ADMIN_TABLE_NEW_ENTRY, ['table' => 'Page']) . '?redirection=' . Tools::getEncodedCurrentURI(),
            'buttons' => ($model->hasId() ? fetch(Application::get()->toRoot('/core/ui/views/admin/panel/sections/table/entry/set_form_button_cancel')) : '')
                . fetch(Application::get()->toRoot('/core/ui/views/admin/panel/sections/table/entry/set_form_button_submit'), [
                    'entry_id' => $model->hasId() ? $model->getId() : null
                ])
        ])
        ?>
    </div>
</div>