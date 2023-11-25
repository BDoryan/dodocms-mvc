<?php
if (!isset($title)) $title = "";
if (!isset($description)) $description = "";
if (!isset($content)) $content = "";
?>
<div class="flex">
    <div class="flex flex-col">
        <h1 class='text-2xl uppercase font-bold'><?= $title ?></h1>
        <p class='mb-3 text-lg italic'><?= $description ?></p>
    </div>
    <?php if (!empty($content)) { ?>
    <div class="flex flex-col ml-auto">
        <?= $content ?>
    </div>
    <?php } ?>
</div>