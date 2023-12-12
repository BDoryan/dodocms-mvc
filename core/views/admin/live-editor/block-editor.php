<?php
if(!isset($block) || !isset($page_structure)) {
    echo "block or page structure is not defined";
    exit;
}
?>
<div page-structure-actions>
    <button page-structure-action="add"></button>
</div>
<div block-name="<?= $block->getName() ?>" page-structure-id="<?= $page_structure->getId() ?? null ?>">
    <div style="background: black; width: 100%; color: white; padding: 10px 15px; "><?= $block->getName() ?? 'unnamed' ?> (id=<?= $block->getId() ?>, structure_id=<?= $page_structure->getId() ?? null?>)</div>
    <div block-content>
        <?= $content ?? '' ?>
    </div>
    <div style="width: 100%; display: flex; flex-direction: row; gap: 10px; padding: 10px; justify-content: end; font-size: medium;">
        <button data-block-action="delete"><?= __('live-editor.block.delete') ?></button>
        <button data-block-action="save"><?= __('live-editor.block.save') ?></button>
    </div>
</div>