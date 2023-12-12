<?php
Header::create()
    ->template('/core/views/admin/components')
    ->title(__('admin.panel.table_management'))
    ->description(__('admin.panel.table_management.description'))
    ->content(
        ButtonHypertext::create()
            ->green()
            ->text('<i class="dodocms-me-1 fa-solid fa-plus-circle"></i> ' . __('admin.panel.dashboard.button.new_table'))
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
<div class="dodocms-flex dodocms-flex-row dodocms-flex-wrap dodocms-my-[30px] -dodocms-mx-2 dodocms-gap-y-5 dodocms-justify-center">
    <?php
    foreach ($tables as $table):
        ?>
        <div class="dodocms-w-auto dodocms-px-2">
            <div class="dodocms-bg-gray-600 dodocms-p-4 dodocms-rounded-xl dodocms-border-[1px] dodocms-border-gray-500 dodocms-shadow-lg dodocms-flex dodocms-flex-col dodocms-h-full">
                <h2 class="dodocms-text-lg dodocms-text-center dodocms-font-semibold"><?= $table->getName() ?></h2>
                <hr class="dodocms-my-4 dodocms-border-t-[1px] dodocms-border-gray-400">
                <ul class="dodocms-my-auto">
                    <?php
                    foreach ($table->getAttributes() as $attribute) {
                        ?>
                        <li class="dodocms-w-min-full dodocms-flex dodocms-flex-row"><span
                                    class="<?= $attribute->isPrimaryKey() ? "underline" : "" ?>"><?= $attribute->hasAssociation() ? "#" : "" ?><?= $attribute->getName() ?></span><span
                                    class="ms-1"> : </span><span
                                    class="dodocms-ms-auto"><?= $attribute->getType() ?></span></li>
                        <?php
                    }
                    ?>
                </ul>
                <div class="dodocms-flex dodocms-flex-row dodocms-gap-3 pt-5">
                    <a href="<?= Routes::route(Routes::ADMIN_TABLES_EDIT, ['table' => $table->getName()]) ?>"
                       class="dodocms-px-3 dodocms-py-1 dodocms-rounded dodocms-bg-green-600 dodocms-text-white dodocms-font-semibold dodocms-uppercase"><i
                                class="dodocms-me-1 fa-solid fa-pen-to-square"></i> <?= __("admin.panel.tables.table.manage") ?></a>
                    <a href="<?= Routes::route(Routes::ADMIN_TABLES_TABLE_ENTRIES, ['table' => $table->getName()]) ?>"
                       class="dodocms-ms-auto dodocms-px-3 dodocms-py-1 dodocms-rounded dodocms-bg-blue-500 dodocms-text-white dodocms-font-semibold dodocms-uppercase"><i
                                class="dodocms-me-1 fa-solid fa-eye"></i><?= __("admin.panel.tables.table.view_content") ?></a>
                </div>
            </div>
        </div>
    <?php
    endforeach;
    ?>
</div>