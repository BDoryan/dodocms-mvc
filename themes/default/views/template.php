<!doctype html>
<html lang="<?= $language ?? "en" ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= $head ?? '' ?>
</head>
<body data-bs-theme="dark">
<div id="app" page-id="<?= $page_id ?? '' ?>">
    <?= $content ?? '' ?>

    <?php
    if ($live_editor ?? false) {
        ?>
        <blocks-modal :ref="`ref_blocks_modal`"></blocks-modal>
        <set-resource-modal :ref="`ref_set_resource_modal`"></set-resource-modal>
        <set-entry-modal :ref="`ref_set_entry_modal`"></set-entry-modal>
        <modal-upload :ref="`ref_upload_modal`"></modal-upload>
        <resources-selector-modal
                :resources="<?= Tools::parseJsonToHtmlAttribute(json_encode(ResourceModel::findAll('*'), JSON_HEX_QUOT)) ?>"
                :ref="`ref_resources_selector_modal`"></resources-selector-modal>
        <?php
    }
    ?>

    <div ref="toastContainer"
         class="tw-max-w-[30vw] tw-fixed tw-right-2 tw-bottom-2 tw-flex tw-flex-col tw-gap-3">
        <?php array_map(function ($toast) {
            $toast->render();
        }, $toasts ?? []); ?>
    </div>
</div>
</body>
</html>