<?php
if(!isset($block) || !isset($page_structure)) {
    echo "block or page structure is not defined";
    exit;
}
?>
<div block-name="<?= $block->getName() ?>" page-structure-id="<?= $page_structure->getId() ?? null ?>" style="border: 1px solid dodgerblue;">
    <div style="background: black; width: 100%; color: white; padding: 10px 15px; "><?= $block->getName() ?? 'unnamed' ?></div>
    <div block-content>
        <?= $content ?? '' ?>
    </div>
    <div style="width: 100%; display: flex; flex-direction: row; gap: 10px; padding: 10px; justify-content: end; font-size: medium;">
        <button data-block-action="delete"><?= __('liveeditor.block.delete') ?></button>
        <button data-block-action="save"><?= __('liveeditor.block.save') ?></button>
    </div>
</div>