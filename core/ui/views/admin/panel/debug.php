<?php

if (Application::get()->isDebugMode()) {
    ?>
    <div x-data="{ showLogs: false }">
        <div class="tw-text-white tw-py-2 tw-px-6 sticky tw-top-0 tw-w-full tw-z-30 tw-bg-indigo-900 tw-flex tw-flex-row tw-gap-4">
            <img class="tw-w-auto tw-max-h-[50px]" src="<?= Application::get()->toURL("/core/assets/imgs/logo.png") ?>">
            <div class="tw-my-auto tw-flex tw-flex-col">
                <h1 class="tw-text-xl tw-uppercase tw-my-auto ms-3 tw-font-bold"><?= __('admin.debug.title') ?></h1>
                <span class="tw-text-sm tw-my-auto ms-3"><?= __('admin.debug.description') ?></span>
            </div>
            <div class="tw-my-auto tw-flex tw-flex-col">
                <h1 class="tw-text-xl tw-uppercase tw-my-auto ms-3 tw-font-bold"><?= __('admin.debug.version') ?></h1>
                <span class="tw-text-sm tw-my-auto ms-3"><?= DodoCMS::VERSION ?></span>
            </div>
            <div class="tw-ms-auto tw-flex tw-my-auto">
                <?php
                Button::create()
                    ->green(700)
                    ->attribute("v-on:click", "showLogs = !showLogs")
                    ->text('<i class="tw-me-1 fa-solid fa-eye"></i> ' . __('admin.debug.read_logs'))
                    ->render();
                ?>
            </div>
        </div>
        <div id="logs" class="tw-whitespace-nowrap tw-max-h-[30vh] tw-overflow-scroll tw-top-0 tw-bottom-0 tw-left-0 tw-right-0 tw-bg-black tw-text-white tw-p-2 tw-text-[16px]" style="font-family: monospace;" x-show="showLogs">
            <?= Application::get()->getLogger()->logsToHTML() ?>
        </div>
    </div>
    <?php
}
?>
