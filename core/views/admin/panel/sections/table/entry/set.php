<?php
if (empty($model)) {
    echo "Model not found";
    exit;
}
?>
<div class="border border-gray-500 bg-gray-600 rounded-xl p-3 border-[1px] text-base w-8/12 mx-auto">
    <form class="flex flex-row flex-wrap -mx-2 gap-y-2" method="post" action="" enctype="multipart/form-data">
        <?php foreach ($model->getFields() as $key => $field): ?>
            <div class="<?= $field["size"] ?> px-2">
                <?= $field["field"]->render() ?>
            </div>
        <?php endforeach; ?>
        <div class="px-2 flex flex-row w-full mt-3">
            <?php
            Button::create()
                ->submittable()
                ->text(isset($entry_id) ? __('admin.panel.tables.table.entries.edit_entry.button') : __('admin.panel.tables.table.entries.new_entry.button'))
                ->addClass("w-full")
                ->blue()
                ->render();
            ?>
        </div>
    </form>
</div>