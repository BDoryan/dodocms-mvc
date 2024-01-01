<?php
if (!isset($block) || !isset($page_structure)) {
    echo "block or page structure is not defined";
    exit;
}
?>
<?= fetch(Application::get()->toRoot('/core/views/admin/live-editor/block-add.php'), ['position' => $position ?? '']) ?>
<div block-name="<?= $block->getName() ?>" page-structure-id="<?= $page_structure->getId() ?? null ?>">
    <div style="display: flex; background: black; width: 100%; color: white; padding: 10px 15px; align-items: center;"><?= $block->getName() ?? 'unnamed' ?>
        <span style="white-space: nowrap">
            (id=<?= $block->getId() ?>, structure_id=<?= $page_structure->getId() ?? null ?>)
        </span>

        <div style="width: 100%; display: flex; flex-direction: row; gap: 10px; padding: 0px 10px; justify-content: end; font-size: medium;">
            <button data-block-action="delete"><?= __('live-editor.block.delete') ?></button>
            <button data-block-action="save"><?= __('live-editor.block.save') ?></button>
        </div>
    </div>
    <div block-content>
        <?= $content ?? '' ?>
    </div>
</div>