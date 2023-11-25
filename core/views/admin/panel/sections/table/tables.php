<?php
Header::create()
    ->template('/core/views/admin/components')
    ->title(__('admin.panel.table_management'))
    ->description(__('admin.panel.table_management.description'))
    ->content(
        ButtonHypertext::create()
            ->green()
            ->text('<i class="fa-solid fa-plus"></i> ' . __('admin.panel.dashboard.button.new_table'))
            ->href(Routes::route(Routes::ADMIN_TABLES_NEW))
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
<div class="flex flex-row flex-wrap my-[30px] -mx-2 gap-y-5 justify-center">
    <?php
    foreach ($tables as $table):
        ?>
        <div class="w-auto px-2">
            <div class="bg-gray-600 p-4 rounded-xl border-[1px] border-gray-500 shadow-lg flex flex-col h-full">
                <h2 class="text-lg text-center font-semibold"><?= $table->getName() ?></h2>
                <hr class="my-4 border-t-[1px] border-gray-400">
                <ul class="my-auto">
                    <?php
                    foreach ($table->getAttributes() as $attribute) {
                        ?>
                        <li class="w-min-full flex flex-row"><span
                                    class="<?= $attribute->isPrimaryKey() ? "underline" : "" ?>"><?= $attribute->hasAssociation() ? "#" : "" ?><?= $attribute->getName() ?></span><span
                                    class="ms-1"> : </span><span
                                    class="ms-auto"><?= $attribute->getType() ?></span></li>
                        <?php
                    }
                    ?>
                </ul>
                <div class="flex flex-row gap-3 pt-5">
                    <a href="<?= Routes::route(Routes::ADMIN_TABLES_EDIT, ['table' => $table->getName()]) ?>"
                       class="px-3 py-1 rounded bg-green-600 text-white font-semibold uppercase"><i
                                class="fa-solid fa-pen-to-square me-1"></i> <?= __("admin.panel.tables.table.manage") ?></a>
                    <a href="<?= Routes::route(Routes::ADMIN_TABLES_EDIT, ['table' => $table->getName()]) ?>"
                       class="ms-auto px-3 py-1 rounded bg-blue-500 text-white font-semibold uppercase"><i
                                class="fa-solid fa-eye me-1"></i><?= __("admin.panel.tables.table.view_content") ?></a>
                </div>
            </div>
        </div>
    <?php
    endforeach;
    ?>
</div>