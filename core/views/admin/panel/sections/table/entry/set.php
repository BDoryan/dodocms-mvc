<?php
if (empty($model)) {
    echo "Model not found";
    return;
}
?>
<div class="entity-set dodocms-border dodocms-border-gray-500 dodocms-bg-gray-600 dodocms-rounded-xl dodocms-p-3 dodocms-text-base dodocms-w-8/12 dodocms-mx-auto">
    <h1 class="dodocms-text-2xl pb-5 dodocms-font-bold dodocms-text-center dodocms-uppercase"><?= $table_name ?? '' ?></h1>
    <form class="dodocms-flex dodocms-flex-row dodocms-flex-wrap -dodocms-mx-2 dodocms-gap-y-2" method="post" action=""
          enctype="multipart/form-data">
        <?php foreach ($model->getFields() as $key => $field) { ?>
            <div class="<?= $field["size"] ?> dodocms-px-2">
                <?= $field["field"]->render() ?>
            </div>
        <?php } ?>
        <div class="dodocms-px-2 dodocms-flex dodocms-flex-row dodocms-w-full dodocms-gap-5 dodocms-mt-3">
            <?php
            ButtonHypertext::create()
                ->href(Routes::route(Routes::ADMIN_TABLES_TABLE_ENTRIES, ["table" => $table_name ?? '']))
                ->text('<i class="dodocms-me-1 fa-solid fa-circle-left"></i> ' . __("admin.panel.tables.table.entries.back"))
                ->addClass("dodocms-w-full")
                ->blue()
                ->render();
            ?>
            <?php
            Button::create()
                ->submittable()
                ->text(isset($entry_id) ? '<i class="dodocms-me-1 fa-solid fa-pen-to-square"></i> ' . __('admin.panel.tables.table.entries.edit_entry.button') : '<i class="dodocms-me-1 fa-solid fa-plus"></i> ' . __('admin.panel.tables.table.entries.new_entry.button'))
                ->addClass("dodocms-w-full")
                ->green()
                ->render();
            ?>
        </div>
    </form>
    <modal-upload></modal-upload>
<!--    --><?php //view(Application::get()->toRoot("core/views/admin/components/resources/upload-modal.php"), ["var" => 'uploadModal']); ?>
<!--    --><?php //view(Application::get()->toRoot("core/views/admin/components/resources/selector-modal.php"), ["var" => 'uploadModal']); ?>
</div>