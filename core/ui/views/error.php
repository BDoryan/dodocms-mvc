<?php

?>
<div class='container tw-my-3 tw-bg-red-700 tw-shadow-lg tw-rounded-lg tw-text-white tw-px-[20px] tw-py-[20px] tw-text-lg'>
    <div class='tw-flex tw-flex-row pb-3 tw-border-b-[1px] tw-border-white'>
        <img src='<?= Application::get()->toURL("/core/assets/imgs/logo.png") ?>' width='80' height='80'/>
        <div class='tw-flex tw-flex-col ms-3'>
            <h1 class='tw-text-4xl tw-uppercase tw-font-bold tw-mt-auto'>DodoCMS</h1>
            <p class='tw-text-2xl tw-mb-auto'><?= __('error.message') ?></p>
        </div>
    </div>
    <div class='tw-py-1'>
        <h2 class='tw-mt-3 tw-text-xl tw-font-bold'><?= __('error.title') . ' : ' . ($errmessage ?? 'empty_message') ?></h2>
        <h3 class='tw-text-lg tw-mt-3 tw-font-bold'><?= __('error.stack_trace') ?></h3>
        <ul class="list-style-none ms-[10px]">
            <li><a class='hover:underline' href='vscode://file/<?= Tools::removeFirstSlash($errfile ?? '') ?>:<?= $errline ?? '' ?>'><?= Tools::removeFirstSlash($errfile ?? '') ?>:<?= $errline ?? ''  ?></a></li>
        </ul>
    </div>
</div>