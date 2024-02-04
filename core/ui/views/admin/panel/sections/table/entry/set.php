<?php
if (empty($model)) {
    echo "Model not found";
    return;
}

$data =  [
    'model' => $model,
    'table_name' => $table_name ?? '',
    'buttons' => $buttons ?? null
];

if(($entry_id ?? null) != null) {
    $entry_id = $model->getId();
    $data['entry_id'] = $entry_id;
}
?>
<div class="entity-set tw-text-gray-700 tw-rounded-lg tw-p-3 tw-text-base tw-w-8/12 tw-mx-auto">
    <h1 class="tw-text-2xl pb-5 tw-font-bold tw-text-center tw-uppercase"><?= $table_name ?? '' ?></h1>
    <?= fetch(Application::get()->toRoot('/core/ui/views/admin/panel/sections/table/entry/set_form.php'), $data) ?>
</div>