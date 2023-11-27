<?php
if (empty($title)) $title = "no_title";
if (empty($description)) $description = "no_description";
if (empty($content)) $content = "";
?>
<div class="flex mb-5">
    <div class="flex flex-col">
        <h1 class='text-2xl uppercase font-bold'><?= $title ?></h1>
        <p class='text-lg italic'><?= $description ?></p>
    </div>
    <?php if (!empty($content)) { ?>
    <div class="ps-4 my-auto whitespace-nowrap flex flex-col gap-2 ml-auto">
        <?= $content ?>
    </div>
    <?php } ?>
</div>