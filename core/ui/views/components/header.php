<?php
if (empty($title)) $title = "no_title";
if (empty($description)) $description = "no_description";
if (empty($content)) $content = "";
?>
<div class="tw-flex tw-flex-wrap tw-grid-cols-2 tw-gap-2 tw-mb-5">
    <div class="lg:col-6 tw-flex-1">
        <h1 class='tw-text-2xl tw-uppercase tw-font-bold'><?= $title ?></h1>
        <p class='tw-text-lg italic'><?= $description ?></p>
    </div>
    <?php if (!empty($content)) { ?>
    <div class="tw-flex     lg:col-6 tw-flex-shrink-0 tw-my-auto tw-whitespace-nowrap">
        <?= $content ?>
    </div>
    <?php } ?>
</div>