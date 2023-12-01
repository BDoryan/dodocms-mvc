<?php view(Application::get()->toRoot('/core/views/components/toast/toast.template.php')) ?>
<?php view(__DIR__ . '/debug.php') ?>
<div class="bg-gray-100 font-sans leading-normal tracking-normal min-h-screen">
    <div class="flex h-screen bg-gray-200">
        <?= $header ?? '' ?>
        <?php view(__DIR__ . '/sidebar.php', ["sidebar" => $sidebar ?? null]) ?>
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-gray-800 text-white shadow">
                <div class="flex items-center justify-between">
                    <span class="ps-4 text-lg font-semibold"><?= __("admin.panel.welcome", ["username" => 'Developper']) ?></span>
                    <a href="<?= Application::get()->toURL("/admin/logout") ?>"
                       class="text-gray-600 focus:outline-none bg-red-600 hover:bg-red-700 text-white font-semibold uppercase p-4">
                        <i class="me-1 fa-solid fa-sign-out"></i> <?= __("admin.logout") ?>
                    </a>
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-700 text-white">
                <div class="px-8 py-8">
                    <?= $content ?? '' ?>
                </div>
            </main>
        </div>
        <?= $footer ?? '' ?>
    </div>
</div>
<div class="toast-container fixed bottom-0 right-0 items-end p-4 flex flex-col gap-3 justify-end h-[50vh] overflow-hidden">
    <!-- Render all toast -->
</div>
<?php array_map(function ($toast) { $toast->render(); }, $toasts ?? []); ?>
