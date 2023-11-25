<div class="min-h-screen flex flex-col items-center justify-center p-4 bg-gradient-to-br from-violet-300 via-violet-200 to-violet-200">
    <div class="backdrop-filter backdrop-blur-lg bg-opacity-50 border border-black border-opacity-20 bg-white p-8 rounded-3xl shadow-lg w-full md:w-4/5 lg:w-4/5 xl:w-2/6">
        <div class="text-center">
            <img class="mx-auto mb-5" width="110" height="110" src="<?= Application::get()->toURL("/core/assets/imgs/logo.png") ?>">
            <h1 class="text-3xl font-semibold text-center mt-3 mb-0"><?= __('admin.login.form.title') ?></h1>

            <form class="text-start flex flex-wrap mt-1" action="<?= Tools::getCurrentURI(); ?>" method="POST"><h2
                        class="px-2 mb-[40px] text-center text-base italic mx-auto"><?= __('admin.login.form.subtitle') ?></h2>
                <div class="mb-4 w-full px-2">
                    <?= Text::create()->template('/core/views/admin/components/field/')->label(__('admin.login.form.username'))->name("username")->placeholder(__('admin.login.form.your_username'))->required()->render() ?>
                </div>
                <div class="mb-4 w-full px-2">
                    <?= Text::create()->template('/core/views/admin/components/field/')->type("password")->label(__('admin.login.form.password'))->name("password")->placeholder(__('admin.login.form.your_password'))->required()->render() ?>
                </div>
                <div class="mb-4 w-full text-center px-2">
                    <button type="submit"
                            class="ml-auto w-auto bg-green-700 text-white py-2 px-4 rounded-md hover:bg-green-800 focus:outline-none focus:shadow-outline-green active:bg-green-800">
                        <?= __('admin.login.form.submit') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>