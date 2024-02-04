<?php

Header::create()
    ->template('/core/ui/views/admin/components')
    ->title(__('admin.panel.table_management'))
    ->description(__('admin.panel.table_management.description'))
    ->content(
        ButtonHypertext::create()
            ->green()
            ->text('<i class="tw-me-1 fa-solid fa-plus-circle"></i> ' . __('admin.panel.dashboard.button.new_table'))
            ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES_NEW))
            ->html()
    )
    ->render();

if (empty($tables)) {
//        Alert::create(Alert::TYPE_INFO)
//            ->title(__('admin.panel.table_management.no_tables'))
//            ->content(__('admin.panel.table_management.no_tables.description'))
//            ->render();
    exit;
}
?>
<div class="tw-flex tw-flex-row tw-flex-wrap tw-my-[30px] -tw-mx-2 tw-gap-y-5 tw-justify-center">
    <?php
    foreach ($tables as $table):
        ?>
        <div class="tw-w-auto tw-px-2">
            <div class="tw-drop-shadow-md tw-text-gray-600 tw-bg-white tw-bg-opacity-70 tw-p-4 tw-rounded-lg tw-flex tw-flex-col tw-h-full">
                <h2 class="tw-text-lg tw-text-center tw-font-semibold"><?= $table->getName() ?></h2>
                <hr class="tw-my-4 tw-border-t-[1px] tw-border-gray-400">
                <ul class="tw-my-auto">
                    <?php
                    foreach ($table->getAttributes() as $attribute) {
                        ?>
                        <li class="tw-w-min-full tw-flex tw-flex-row"><span
                                    class="<?= $attribute->isPrimaryKey() ? "underline" : "" ?>"><?= $attribute->hasAssociation() ? "#" : "" ?><?= $attribute->getName() ?></span><span
                                    class="ms-1"> : </span><span
                                    class="tw-ms-auto"><?= $attribute->getType() ?></span></li>
                        <?php
                    }
                    ?>
                </ul>
                <div class="tw-flex tw-flex-row tw-gap-3 pt-5">
                    <?php
                    ButtonHypertext::create()
                        ->text('<i class="tw-me-1 fa-solid fa-pen-to-square"></i> '. __('admin.panel.tables.table.manage'))
                        ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES_EDIT, ['table' => $table->getName()]))
                        ->green()
                        ->render()
                    ?>
                    <?php
                    ButtonHypertext::create()
                        ->text('<i class="tw-me-1 fa-solid fa-eye"></i>'. __("admin.panel.tables.table.view_content"))
                        ->href( DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES_TABLE_ENTRIES, ['table' => $table->getName()]) )
                        ->blue()
                        ->render()
                    ?>
<!--                    <a href="--><?php //= DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES_EDIT, ['table' => $table->getName()]) ?><!--"-->
<!--                       class="tw-px-3 tw-py-1 tw-rounded tw-bg-green-600 tw-text-white tw-font-semibold tw-uppercase"><i-->
<!--                                class="tw-me-1 fa-solid fa-pen-to-square"></i> --><?php //= __("admin.panel.tables.table.manage") ?><!--</a>-->
<!--                    <a href="--><?php //= DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES_TABLE_ENTRIES, ['table' => $table->getName()]) ?><!--"-->
<!--                       class="tw-ms-auto tw-px-3 tw-py-1 tw-rounded tw-bg-blue-500 tw-text-white tw-font-semibold tw-uppercase"><i-->
<!--                                class="tw-me-1 fa-solid fa-eye"></i>--><?php //= __("admin.panel.tables.table.view_content") ?><!--</a>-->
                </div>
            </div>
        </div>
    <?php
    endforeach;
    ?>
</div>