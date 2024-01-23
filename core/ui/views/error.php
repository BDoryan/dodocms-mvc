<?php

?>
<div class='container dodocms-my-3 dodocms-bg-red-700 dodocms-shadow-lg dodocms-rounded-xl dodocms-text-white dodocms-px-[20px] dodocms-py-[20px] dodocms-text-lg'>
    <div class='dodocms-flex dodocms-flex-row pb-3 dodocms-border-b-[1px] dodocms-border-white'>
        <img src='<?= Application::get()->toURL("/core/admin/assets/imgs/logo.png") ?>' width='80' height='80'/>
        <div class='dodocms-flex dodocms-flex-col ms-3'>
            <h1 class='dodocms-text-4xl dodocms-uppercase dodocms-font-bold dodocms-mt-auto'>DodoCMS</h1>
            <p class='dodocms-text-2xl dodocms-mb-auto'><?= __('error.message') ?></p>
        </div>
    </div>
    <div class='dodocms-py-1'>
        <h2 class='dodocms-mt-3 dodocms-text-xl dodocms-font-bold'><?= __('error.title') . ' : ' . ($errmessage ?? 'empty_message') ?></h2>
        <h3 class='dodocms-text-lg dodocms-mt-3 dodocms-font-bold'><?= __('error.stack_trace') ?></h3>
        <ul class="list-style-none ms-[10px]">
            <li><a class='hover:underline' href='vscode://file/<?= Tools::removeFirstSlash($errfile ?? '') ?>:<?= $errline ?? '' ?>'><?= Tools::removeFirstSlash($errfile ?? '') ?>:<?= $errline ?? ''  ?></a></li>
        </ul>
    </div>
</div>