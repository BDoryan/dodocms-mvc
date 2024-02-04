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
/** @var PageModel $model */
?>
<div class="tw-flex tw-wrap tw-mt-5 tw-gap-3">
    <div class="tw-w-1/2 tw-border-[1px] tw-border-gray-700 tw-border-opacity-25  tw-drop-shadow-md tw-text-gray-600 tw-bg-white tw-bg-opacity-70 tw-rounded-lg tw-p-4">
        <h2 class="tw-text-lg tw-font-semibold tw-border-b-[1px] tw-border-b-gray-300 tw-mb-2 tw-pb-2"><?= __($model->hasId() ? 'admin.panel.pages.page.edit' : 'admin.panel.pages.page.create') ?></h2>
        <?php
        Model::renderForm($model ?? null, [
            'action' => DefaultRoutes::route(DefaultRoutes::ADMIN_TABLE_NEW_ENTRY, ['table' => $model->getTableName()]) . '?redirection=' . Tools::getEncodedCurrentURI(),
            'buttons' => ($model->hasId() ? fetch(Application::get()->toRoot('/core/ui/views/admin/panel/sections/table/entry/set_form_button_back')) : '')
                . fetch(Application::get()->toRoot('/core/ui/views/admin/panel/sections/table/entry/set_form_button_submit'), [
                    'entry_id' => $model->hasId() ? $model->getId() : null
                ])
        ])
        ?>
    </div>
    <div class="tw-w-1/2 tw-border-[1px] tw-border-gray-700 tw-border-opacity-25  tw-drop-shadow-md tw-text-gray-600 tw-bg-white tw-bg-opacity-70 tw-rounded-lg tw-p-4">
        <h2 class="tw-text-lg tw-font-semibold tw-border-b-[1px] tw-border-b-gray-300 tw-mb-2 tw-pb-2"><?= __('admin.panel.pages.page.blocks.title') ?></h2>
        <div class="tw-flex tw-flex-col tw-gap-3">
            <?php
            $blocks_in_structure = $model->hasId() ? $model->getPageStructures() : [];
            /** @var PageStructureModel $block */
            foreach ($blocks_in_structure as $block) {
                ?>
                    <div class="tw-flex tw-bg-white tw-border-[1px] tw-border-gray-300 tw-p-3 tw-rounded-lg">
                        <?=
                        $block->getBlock()->getName() ?>
                        <div class="tw-ms-auto">
                            <?php
                                ButtonHypertext::create()
                                ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_TABLE_DELETE_ENTRY, ['table' => $block->getTableName(), 'id' => $block->getId()]).'?redirection='.Tools::getEncodedCurrentURI())
                                ->text('<i class="tw-me-1 fa-solid fa-trash"></i> ' . __('admin.panel.pages.page.blocks.remove'))
                                ->red()
                                ->render();
                            ?>
                        </div>
                    </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>