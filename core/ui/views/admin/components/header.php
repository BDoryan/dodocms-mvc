<?php
if (empty($title)) $title = "no_title";
if (empty($description)) $description = "no_description";
if (empty($content)) $content = "";
?>
<div class="dodocms-flex dodocms-flex-wrap dodocms-grid-cols-2 dodocms-gap-2 dodocms-mb-5">
    <div class="lg:col-6 dodocms-flex-1">
        <h1 class='dodocms-text-2xl dodocms-uppercase dodocms-font-bold'><?= $title ?></h1>
        <p class='dodocms-text-lg italic'><?= $description ?></p>
    </div>
    <?php if (!empty($content)) { ?>
    <div class="dodocms-flex     lg:col-6 dodocms-flex-shrink-0 dodocms-my-auto dodocms-whitespace-nowrap">
        <?= $content ?>
    </div>
    <?php } ?>
</div>