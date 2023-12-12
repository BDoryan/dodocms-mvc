<?php
if (empty($title)) $title = "no_title";
if (empty($description)) $description = "no_description";
if (empty($content)) $content = "";
?>
<div class="dodocms-flex dodocms-mb-5">
    <div class="dodocms-flex dodocms-flex-col">
        <h1 class='dodocms-text-2xl dodocms-uppercase dodocms-font-bold'><?= $title ?></h1>
        <p class='dodocms-text-lg italic'><?= $description ?></p>
    </div>
    <?php if (!empty($content)) { ?>
    <div class="dodocms-ps-4 dodocms-my-auto dodocms-whitespace-nowrap dodocms-flex dodocms-flex-col dodocms-p-2 dodocms-ml-auto">
        <?= $content ?>
    </div>
    <?php } ?>
</div>