<?php

if (Application::get()->isDebugMode()) {
    ?>
    <div x-data="{ showLogs: false }">
        <div class="dodocms-text-white dodocms-py-2 dodocms-px-6 sticky dodocms-top-0 dodocms-w-full dodocms-z-30 dodocms-bg-indigo-900 dodocms-flex dodocms-flex-row dodocms-gap-4">
            <img class="dodocms-w-auto dodocms-max-h-[50px]" src="<?= Application::get()->toURL("/core/assets/imgs/logo.png") ?>">
            <div class="dodocms-my-auto dodocms-flex dodocms-flex-col">
                <h1 class="dodocms-text-xl dodocms-uppercase dodocms-my-auto ms-3 dodocms-font-bold"><?= __('admin.debug.title') ?></h1>
                <span class="dodocms-text-sm dodocms-my-auto ms-3"><?= __('admin.debug.description') ?></span>
            </div>
            <div class="dodocms-my-auto dodocms-flex dodocms-flex-col">
                <h1 class="dodocms-text-xl dodocms-uppercase dodocms-my-auto ms-3 dodocms-font-bold"><?= __('admin.debug.version') ?></h1>
                <span class="dodocms-text-sm dodocms-my-auto ms-3"><?= DodoCMS::VERSION ?></span>
            </div>
            <div class="dodocms-ms-auto dodocms-flex dodocms-my-auto">
                <?php
                Button::create()
                    ->green(700)
                    ->attribute("v-on:click", "showLogs = !showLogs")
                    ->text('<i class="dodocms-me-1 fa-solid fa-eye"></i> ' . __('admin.debug.read_logs'))
                    ->render();
                ?>
            </div>
        </div>
        <div id="logs" class="dodocms-whitespace-nowrap dodocms-max-h-[30vh] dodocms-overflow-scroll dodocms-top-0 dodocms-bottom-0 dodocms-left-0 dodocms-right-0 dodocms-bg-black dodocms-text-white dodocms-p-2 dodocms-text-[16px]" style="font-family: monospace;" x-show="showLogs">
            <?= Application::get()->getLogger()->logsToHTML() ?>
        </div>
    </div>
    <?php
}
?>
