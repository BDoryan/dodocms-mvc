
<form class="tw-flex tw-flex-row tw-flex-wrap -tw-mx-2 tw-gap-y-2" method="post" action=""
      enctype="multipart/form-data">
    <?php

    foreach ($model->getFields() as $key => $field) { ?>
        <div class="<?= $field["size"] ?> tw-px-2">
            <?= $field["field"]->render() ?>
        </div>
    <?php } ?>
    <?php if (!isset($show_buttons) || $show_buttons) { ?>
    <div class="tw-order-2 tw-px-2 tw-flex tw-flex-row tw-w-full tw-gap-5 tw-mt-3">
        <?php
        ButtonHypertext::create()
            ->href(DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES_TABLE_ENTRIES, ["table" => $table_name ?? '']))
            ->text('<i class="tw-me-1 fa-solid fa-circle-left"></i> ' . __("admin.panel.tables.table.entries.back"))
            ->addClass("tw-w-full")
            ->blue()
            ->render();
        ?>
        <?php
        Button::create()
            ->submittable()
            ->text(isset($entry_id) ? '<i class="tw-me-1 fa-solid fa-pen-to-square"></i> ' . __('admin.panel.tables.table.entries.edit_entry.button') : '<i class="tw-me-1 fa-solid fa-plus"></i> ' . __('admin.panel.tables.table.entries.new_entry.button'))
            ->addClass("tw-w-full")
            ->green()
            ->render();
        ?>
    </div>
    <?php } ?>
</form>