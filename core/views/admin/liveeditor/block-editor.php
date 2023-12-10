<?php
if(!isset($block)) {
    echo "block is not defined";
    exit;
}
?>
<div block-name="<?= $block->getName() ?>" page-block-id="<?= $page_block_id ?? null ?>" style="border: 1px solid red;">
    <div style="background: black; width: 100%; color: white; padding: 10px 15px; "><?= $block->getName() ?? 'unnamed' ?></div>
    <div block-content>
        <?= $content ?? '' ?>
    </div>
    <div style="width: 100%; display: flex; flex-direction: row; gap: 10px; padding: 10px; justify-content: end; font-size: medium;">
        <button data-block-action="delete" style="border-radius: 5px; border: none; background: firebrick; padding: 10px 8px"><?= __('liveeditor.block.delete') ?></button>
        <button data-block-action="save" style="border-radius: 5px; border: none; background: darkgreen; padding: 10px 8px"><?= __('liveeditor.block.save') ?></button>
    </div>
</div>