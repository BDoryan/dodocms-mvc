<?php
if (empty($model)) {
    echo "Model not found";
    return;
}

$data =  [
    'model' => $model,
    'table_name' => $table_name
];

if($entry_id != null) {
    $entry_id = $model->getId();
    $data['entry_id'] = $entry_id;
}
?>
<div class="entity-set dodocms-border dodocms-border-gray-500 dodocms-bg-gray-600 dodocms-rounded-xl dodocms-p-3 dodocms-text-base dodocms-w-8/12 dodocms-mx-auto">
    <h1 class="dodocms-text-2xl pb-5 dodocms-font-bold dodocms-text-center dodocms-uppercase"><?= $table_name ?? '' ?></h1>
    <?= fetch(Application::get()->toRoot('/core/admin/views/panel/sections/table/entry/set_form.php'), $data) ?>
</div>