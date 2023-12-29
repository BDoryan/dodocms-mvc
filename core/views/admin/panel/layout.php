<?php view(Application::get()->toRoot('/core/views/components/toast/toast.template.php')) ?>
<?php view(__DIR__ . '/debug.php') ?>
<div class="dodocms-bg-gray-100 dodocms-font-sans dodocms-leading-normal dodocms-tracking-normal dodocms-min-h-screen">
    <div class="dodocms-flex dodocms-h-screen dodocms-bg-gray-200">
        <?= $header ?? '' ?>
        <?php view(__DIR__ . '/sidebar.php', ["sidebar" => $sidebar ?? null]) ?>
        <div class="dodocms-flex-1 dodocms-flex dodocms-flex-col dodocms-overflow-dodocms-hidden">
            <header class="dodocms-bg-gray-800 dodocms-text-white dodocms-shadow">
                <div class="dodocms-flex dodocms-items-center dodocms-justify-between">
                    <span class="dodocms-ps-4 dodocms-text-lg dodocms-font-semibold"><?= __("admin.panel.welcome", ["username" => 'Developper']) ?></span>
                    <a href="<?= Application::get()->toURL("/admin/logout") ?>"
                       class="focus:dodocms-outline-none dodocms-bg-red-600 hover:dodocms-bg-red-700 dodocms-text-white dodocms-font-semibold dodocms-uppercase dodocms-p-4">
                        <i class="dodocms-me-1 fa-solid fa-sign-out"></i> <?= __("admin.logout") ?>
                    </a>
                </div>
            </header>
            <main class="dodocms-flex-1 dodocms-overflow-x-dodocms-hidden dodocms-overflow-y-auto dodocms-bg-gray-700 dodocms-text-white">
                <div class="dodocms-px-8 dodocms-py-8">
                    <?= $content ?? '' ?>
                </div>
            </main>
        </div>
        <?= $footer ?? '' ?>
    </div>
</div>
<div ref="toastContainer" class="dodocms-max-w-[25vw] toast-container dodocms-fixed dodocms-bottom-0 dodocms-right-0 dodocms-items-end dodocms-p-4 dodocms-flex dodocms-flex-col dodocms-gap-3 dodocms-justify-end dodocms-overflow-hidden dodocms-z-50">
<!--    <toast type="info" title="info" message="Lorem uid zahnuidzauod zapidh jzaoidhza pdiuhzn oduzhndoiazh diuaznhdiuha nziuhdzaiuàdhza npjzapod jaz;idjaz ,daz ohduzaidhpzdaz"></toast>-->
<!--    <toast type="error" title="error" message="Lorem uid zahnuidzauod zapidh jzaoidhza pdiuhzn oduzhndoiazh diuaznhdiuha nziuhdzaiuàdhza npjzapod jaz;idjaz ,daz ohduzaidhpzdaz"></toast>-->
<!--    <toast type="success" title="success" message="Lorem uid zahnuidzauod zapidh jzaoidhza pdiuhzn oduzhndoiazh diuaznhdiuha nziuhdzaiuàdhza npjzapod jaz;idjaz ,daz ohduzaidhpzdaz"></toast>-->
<!--    <toast type="warning" title="warning" message="Lorem uid zahnuidzauod zapidh jzaoidhza pdiuhzn oduzhndoiazh diuaznhdiuha nziuhdzaiuàdhza npjzapod jaz;idjaz ,daz ohduzaidhpzdaz"></toast>-->
    <?php array_map(function ($toast) { $toast->render(); }, $toasts ?? []); ?>
</div>
