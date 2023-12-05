<?php
if (empty($model)) {
    echo "Model not found";
    return;
}
?>
<div class="entity-set border border-gray-500 bg-gray-600 rounded-xl p-3 border-[1px] text-base w-8/12 mx-auto">
    <h1 class="text-2xl pb-5 font-bold text-center uppercase"><?= $table_name ?? '' ?></h1>
    <form class="flex flex-row flex-wrap -mx-2 gap-y-2" method="post" action="" enctype="multipart/form-data">
        <?php foreach ($model->getFields() as $key => $field) { ?>
            <div class="<?= $field["size"] ?> px-2">
                <?= $field["field"]->render() ?>
            </div>
        <?php } ?>
        <div class="px-2 flex flex-row w-full gap-5 mt-3">
            <?php
            ButtonHypertext::create()
                ->href(Routes::route(Routes::ADMIN_TABLES_TABLE_ENTRIES, ["table" => $table_name ?? '']))
                ->text('<i class="me-1 fa-solid fa-circle-left"></i> ' . __("admin.panel.tables.table.entries.back"))
                ->addClass("w-full")
                ->blue()
                ->render();
            ?>
            <?php
            Button::create()
                ->submittable()
                ->text(isset($entry_id) ? '<i class="me-1 fa-solid fa-pen-to-square"></i> ' . __('admin.panel.tables.table.entries.edit_entry.button') : '<i class="me-1 fa-solid fa-plus"></i> ' . __('admin.panel.tables.table.entries.new_entry.button'))
                ->addClass("w-full")
                ->green()
                ->render();
            ?>
        </div>
    </form>
    <?php view(Application::get()->toRoot("core/views/admin/components/resources/upload.php"), ["var" => 'uploadModal']); ?>
</div>
<script>
    $(document).on('resource:file_uploaded', (event, data) => {
        console.log("add file to list");
        console.log(data);
    })
</script>