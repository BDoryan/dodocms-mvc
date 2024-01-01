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
        <div id="app">
            <?= $content ?? '' ?>

            <modal-upload :ref="`ref_upload_modal`"></modal-upload>
            <resources-selector-modal :resources="<?= Tools::parseJsonToHtmlAttribute(json_encode(ResourceModel::findAll('*'), JSON_HEX_QUOT)) ?>" :ref="`ref_resources_selector_modal`"></resources-selector-modal>
            <blocks-modal :ref="`ref_blocks_modal`"></blocks-modal>

            <div ref="toastContainer" class="dodocms-max-w-[30vw] dodocms-fixed dodocms-right-2 dodocms-bottom-2 dodocms-flex dodocms-flex-col dodocms-gap-3">
                <?php array_map(function ($toast) { $toast->render(); }, $toasts ?? []); ?>
            </div>
        </div>
    </body>
</html>