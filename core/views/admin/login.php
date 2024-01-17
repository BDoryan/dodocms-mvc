<div class="dodocms-min-h-screen dodocms-flex dodocms-flex-col dodocms-items-center dodocms-justify-center dodocms-p-4 dodocms-bg-gradient-to-br dodocms-from-violet-300 dodocms-via-violet-200 dodocms-to-violet-200">
    <div class="dodocms-backdrop-filter dodocms-backdrop-blur-lg dodocms-bg-opacity-50 dodocms-border dodocms-border-black dodocms-border-opacity-20 dodocms-bg-white dodocms-p-8 dodocms-rounded-3xl dodocms-shadow-lg dodocms-w-full md:dodocms-w-4/5 lg:dodocms-w-4/5 xl:dodocms-w-2/6">
        <div class="dodocms-text-center">
            <img class="dodocms-mx-auto dodocms-mb-5" width="110" height="110"
                 src="<?= Application::get()->toURL("/core/assets/imgs/logo.png") ?>">
            <h1 class="dodocms-text-3xl dodocms-font-semibold dodocms-text-center dodocms-mt-3 dodocms-mb-0"><?= __('admin.login.form.title') ?></h1>

            <form class="dodocms-text-start dodocms-flex dodocms-flex-wrap dodocms-mt-1"
                  action="<?= Tools::getCurrentURI(); ?>" method="POST"><h2
                        class="dodocms-px-2 mb-[40px] dodocms-text-center dodocms-text-base italic dodocms-mx-auto"><?= __('admin.login.form.subtitle') ?></h2>
                <div class="dodocms-mb-4 dodocms-w-full dodocms-px-2">
                    <?php
                    Text::create()->template('/core/views/admin/components/field/')->label(__('admin.login.form.username'))->name("email")->placeholder(__('admin.login.form.your_username'))->required()->render()
                    ?>
                </div>
                <div class="dodocms-mb-4 dodocms-w-full dodocms-px-2">
                    <?php
                    Text::create()->template('/core/views/admin/components/field/')->type("password")->label(__('admin.login.form.password'))->name("password")->placeholder(__('admin.login.form.your_password'))->required()->render()
                    ?>
                </div>
                <div class="dodocms-mb-4 dodocms-w-full dodocms-text-center dodocms-px-2">
                    <button type="submit"
                            class="dodocms-ml-auto dodocms-w-auto dodocms-bg-green-700 dodocms-text-white dodocms-py-2 dodocms-px-4 dodocms-rounded-md hover:dodocms-bg-green-800 focus:dodocms-outline-none focus:dodocms-shadow-outline-green active:dodocms-bg-green-800">
                        <?= __('admin.login.form.submit') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div ref="toastContainer"
     class="dodocms-max-w-[30vw] toast-container dodocms-fixed dodocms-bottom-0 dodocms-right-0 dodocms-items-end dodocms-p-4 dodocms-flex dodocms-flex-col dodocms-gap-3 dodocms-justify-end dodocms-overflow-hidden dodocms-z-50">
    <?php array_map(function ($toast) {
        $toast->render();
    }, $toasts ?? []); ?>
</div>
