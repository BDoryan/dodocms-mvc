<?php view(Application::get()->toRoot('/core/ui/views/components/toast/toast.template.php')) ?>
<?php view(__DIR__ . '/debug.php') ?>
<div class="tw-bg-gray-100 tw-font-sans tw-leading-normal tw-tracking-normal tw-min-h-screen">
    <div class="tw-flex tw-h-screen tw-bg-gray-200">
        <?= $header ?? '' ?>
        <?php view(__DIR__ . '/sidebar.php', ["sidebar" => $sidebar ?? null]) ?>
        <div class="tw-flex-1 tw-flex tw-flex-col tw-overflow-hidden">
            <header class="tw-bg-gray-800 tw-text-white tw-shadow">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <span class="tw-ps-4 tw-text-lg tw-font-semibold"><?= __("admin.panel.welcome", ["username" => Session::getUser()->getUsername()]) ?></span>
                    <a href="<?= Application::get()->toURL("/admin/logout") ?>"
                       class="focus:tw-outline-none tw-bg-red-600 hover:tw-bg-red-700 tw-text-white tw-font-semibold tw-uppercase tw-p-4">
                        <i class="tw-me-1 fa-solid fa-sign-out"></i> <?= __("admin.logout") ?>
                    </a>
                </div>
            </header>
            <main class="tw-flex-1 tw-overflow-x-auto tw-overflow-y-auto tw-bg-gray-700 tw-text-white">
                <div class="tw-px-8 tw-py-8">
                    <?= $content ?? '' ?>
                </div>
            </main>
        </div>
        <modal-upload :ref="`ref_upload_modal`"></modal-upload>
        <resources-selector-modal :resources="<?= Tools::parseJsonToHtmlAttribute(json_encode(ResourceModel::findAll('*'), JSON_HEX_QUOT)) ?>" :ref="`ref_resources_selector_modal`"></resources-selector-modal>
        <?= $footer ?? '' ?>
    </div>
</div>
<div ref="toastContainer" class="tw-max-w-[30vw] toast-container tw-fixed tw-bottom-0 tw-right-0 tw-items-end tw-p-4 tw-flex tw-flex-col tw-gap-3 tw-justify-end tw-overflow-hidden tw-z-50">
    <?php array_map(function ($toast) { $toast->render(); }, $toasts ?? []); ?>
</div>
