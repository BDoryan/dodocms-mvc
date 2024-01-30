<div class="tw-min-h-screen tw-flex tw-flex-col tw-items-center tw-justify-center tw-p-4 tw-bg-gradient-to-br tw-from-violet-300 tw-via-violet-200 tw-to-violet-200">
    <div class="tw-backdrop-filter tw-backdrop-blur-lg tw-bg-opacity-50 tw-border tw-border-black tw-border-opacity-20 tw-bg-white tw-p-8 tw-rounded-3xl tw-shadow-lg tw-w-full md:tw-w-4/5 lg:tw-w-4/5 xl:tw-w-2/6">
        <div class="tw-text-center">
            <img class="tw-mx-auto tw-mb-5" width="110" height="110"
                 src="<?= Application::get()->toURL("/core/assets/imgs/logo-animated.png") ?>">
            <h1 class="tw-text-3xl tw-font-semibold tw-text-center tw-mt-3 tw-mb-0"><?= __('admin.login.form.title') ?></h1>

            <form class="tw-text-start tw-flex tw-flex-wrap tw-mt-1"
                  action="<?= Tools::getCurrentURI(); ?>" method="POST"><h2
                        class="tw-px-2 mb-[40px] tw-text-center tw-text-base italic tw-mx-auto"><?= __('admin.login.form.subtitle') ?></h2>
                <div class="tw-mb-4 tw-w-full tw-px-2">
                    <?php
                    Text::create()->template('/core/ui/views/admin/components/field/')->label(__('admin.login.form.username'))->name("email")->placeholder(__('admin.login.form.your_username'))->required()->render()
                    ?>
                </div>
                <div class="tw-mb-4 tw-w-full tw-px-2">
                    <?php
                    Text::create()->template('/core/ui/views/admin/components/field/')->type("password")->label(__('admin.login.form.password'))->name("password")->placeholder(__('admin.login.form.your_password'))->required()->render()
                    ?>
                </div>
                <div class="tw-mb-4 tw-w-full tw-text-center tw-px-2">
                    <button type="submit"
                            class="tw-ml-auto tw-w-auto tw-bg-green-700 tw-text-white tw-py-2 tw-px-4 tw-rounded-md hover:tw-bg-green-800 focus:tw-outline-none focus:tw-shadow-outline-green active:tw-bg-green-800">
                        <?= __('admin.login.form.submit') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div ref="toastContainer"
     class="tw-max-w-[30vw] toast-container tw-fixed tw-bottom-0 tw-right-0 tw-items-end tw-p-4 tw-flex tw-flex-col tw-gap-3 tw-justify-end tw-overflow-hidden tw-z-50">
    <?php array_map(function ($toast) {
        $toast->render();
    }, $toasts ?? []); ?>
</div>
