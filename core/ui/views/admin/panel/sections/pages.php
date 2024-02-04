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
            'action' => DefaultRoutes::route(DefaultRoutes::ADMIN_TABLE_NEW_ENTRY, ['table' => 'Page']) . '?redirection=' . Tools::getEncodedCurrentURI(),
            'buttons' => ($model->hasId() ? fetch(Application::get()->toRoot('/core/ui/views/admin/panel/sections/table/entry/set_form_button_cancel')) : '')
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
            $blocks = $model->getBlocks();

            /** @var BlockModel $block */
            foreach ($blocks as $block) {
                ?>
                <div class="tw-flex tw-flex-row tw-justify-between tw-items-center tw-p-2 tw-bg-gray-800 tw-rounded-lg tw-border-[1px] tw-border-gray-700 tw-border-opacity-25">
                    <div class="tw-flex tw-flex-row tw-items-center">
                        <i class="fa-solid fa-cube tw-text-gray-400 tw-mr-2"></i>
                        <span class="tw-text-gray-400"><?= $block->getTitle() ?></span>
                    </div>
                    <div class="tw-flex tw-flex-row tw-items-center">
                        <a href="<?= DefaultRoutes::route(DefaultRoutes::ADMIN_TABLE_EDIT_ENTRY, ['table' => 'Block', 'id' => $block->getId()]) ?>"
                           class="tw-text-gray-400 tw-mr-2 hover:tw-text-gray-300">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <a href="<?= DefaultRoutes::route(DefaultRoutes::ADMIN_TABLE_DELETE_ENTRY, ['table' => 'Block', 'id' => $block->getId()]) ?>"
                           class="tw-text-gray-400 hover:tw-text-gray-300">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>