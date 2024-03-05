<?php view(Application::get()->toRoot('/core/ui/views/components/toast/toast.template.php')) ?>
<?php view(__DIR__ . '/debug.php') ?>
<div class="tw-font-sans tw-leading-normal tw-tracking-normal tw-min-h-screen">
    <div class="tw-flex tw-h-screen tw-p-4 tw-bg-gradient-to-br tw-from-violet-300 tw-via-violet-200 tw-to-violet-200">
        <?= $header ?? '' ?>
        <?php view(__DIR__ . '/sidebar.php', ["sidebar" => $sidebar ?? null]) ?>
        <div class="tw-flex-1 tw-flex tw-flex-col tw-overflow-hidden">
            <header class="tw-text-white tw-px-3 tw-pb-3">
                <div class="tw-flex tw-items-center tw-justify-between tw-backdrop-filter tw-backdrop-blur-lg tw-bg-opacity-50 tw-border tw-border-black tw-border-opacity-20 tw-bg-white tw-rounded-2xl tw-overflow-hidden tw-shadow-sm">
                    <span class="tw-text-gray-700 tw-ps-4 tw-text-lg tw-font-semibold"><?= __("admin.panel.welcome", ["username" => Session::getAdminUser()->getUsername()]) ?></span>
                    <a href="<?= NativeRoutes::getRoute(NativeRoutes::ADMIN_LOGOUT) ?>"
                       class="focus:tw-outline-none tw-bg-red-600 hover:tw-bg-red-700 tw-text-white tw-font-semibold tw-uppercase tw-p-4">
                        <i class="tw-me-1 fa-solid fa-sign-out"></i> <?= __("admin.logout") ?>
                    </a>
                </div>
            </header>
            <main class="tw-flex-1 tw-overflow-x-hidden tw-overflow-y-auto tw-text-white tw-px-3">
                <div class="tw-h-full tw-backdrop-filter tw-backdrop-blur-lg tw-bg-opacity-50 tw-border tw-border-black tw-border-opacity-20 tw-bg-white tw-rounded-2xl tw-overflow-hidden tw-shadow-sm">
                    <div class="tw-p-4 tw-text-gray-700 tw-h-full tw-overflow-auto">
                        <?= $content ?? '' ?>
                    </div>
                </div>
            </main>
        </div>
        <modal-upload :ref="`ref_upload_modal`"></modal-upload>
        <resources-selector-modal
                :resources="<?= Tools::parseJsonToHtmlAttribute(json_encode(ResourceModel::findAll('*'), JSON_HEX_QUOT)) ?>"
                :ref="`ref_resources_selector_modal`"></resources-selector-modal>
        <?= $footer ?? '' ?>
    </div>
</div>
<div ref="toastContainer"
     class="tw-max-w-[30vw] toast-container tw-fixed tw-bottom-0 tw-right-0 tw-items-end tw-p-4 tw-flex tw-flex-col tw-gap-3 tw-justify-end tw-overflow-hidden tw-z-50">
    <?php array_map(function ($toast) {
        $toast->render();
    }, $toasts ?? []); ?>
</div>
