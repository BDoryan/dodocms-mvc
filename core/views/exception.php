<?php

if (empty($e)) {
    echo "DodoCMS, try to render error but error is empty";
    exit;
}

//echo "<pre>";
//var_dump($e);
//exit;

$message = $e->getMessage();
$traces = $e->getTrace();

?>
<div class='container my-3 bg-red-700 shadow-lg rounded-xl text-white px-[20px] py-[20px] text-lg'>
    <div class='flex flex-row pb-3 border-b-[1px] border-white'>
        <img src='<?= Application::get()->toURL("/core/assets/imgs/logo.png") ?>' width='80' height='80'/>
        <div class='flex flex-col ms-3'>
            <h1 class='text-4xl uppercase font-bold mt-auto'>DodoCMS</h1>
            <p class='text-2xl mb-auto'><?= __('error.message') ?></p>
        </div>
    </div>
    <div class='py-1'>
        <h2 class='mt-3 text-xl font-bold'><?= __('error.title') . ' : ' . $message ?></h2>
        <h3 class='text-lg mt-3 font-bold'><?= __('error.stack_trace') ?></h3>
        <ul class="list-style-none ms-[10px]">
            <li><a class='hover:underline' href='vscode://file/<?= Tools::removeFirstSlash($e->getFile()) ?>:<?= $e->getLine() ?>'><?= Tools::removeFirstSlash($e->getFile()) ?>:<?= $e->getLine()  ?></a></li>
        <?php foreach ($traces as $trace) {
            $errfile = $trace['file'];
            $errline = $trace['line'];
            ?>
            <li><a class='hover:underline' href='vscode://file/<?= Tools::removeFirstSlash($errfile) ?>:<?= $errline ?>'><?= $errfile ?>:<?= $errline ?></a></li>
            <?php
        }
        ?>
        </ul>
    </div>
</div>