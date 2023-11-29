<?php
if (Application::get()->isDebugMode()) {
    ?>
    <div x-data="{ showLogs: false }">
        <div class="bg-gray-800 text-white py-2 px-6 sticky top-0 w-full z-30 bg-indigo-900 flex flex-row gap-2">
            <img class="w-auto max-h-[50px]" src="<?= Application::get()->toURL("/core/assets/imgs/logo.png") ?>">
            <div class="my-auto flex flex-col">
                <h1 class="text-xl uppercase my-auto ms-3 font-bold"><?= __('admin.debug.title') ?></h1>
                <span class="text-sm my-auto ms-3"><?= __('admin.debug.description') ?></span>
            </div>
            <div class="my-auto flex flex-col">
                <h1 class="text-xl uppercase my-auto ms-3 font-bold"><?= __('admin.debug.version') ?></h1>
                <span class="text-sm my-auto ms-3"><?= DodoCMS::VERSION ?></span>
            </div>
            <div class="ms-auto flex my-auto">
                <?php
                Button::create()
                    ->green(700)
                    ->attribute("@click", "showLogs = !showLogs")
                    ->text('<i class="me-1 fa-solid fa-eye"></i> ' . __('admin.debug.read_logs'))
                    ->render();
                ?>
            </div>
        </div>
        <div id="logs" class="whitespace-nowrap max-h-[30vh] overflow-scroll top-0 bottom-0 left-0 right-0 bg-black text-white p-2 text-[16px]" style="font-family: monospace;" x-show="showLogs">
            <?= Application::get()->getLogger()->logsToHTML() ?>
        </div>
    </div>
    <?php
}
?>
