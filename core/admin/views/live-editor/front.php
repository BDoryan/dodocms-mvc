<div liveeditor-bar>
    <img class="dodocms-logo" src="<?= Application::get()->toURL('core/admin/assets/imgs/logo.png')?>" alt="DodoCMS">
    <button liveeditor-action="save"><?= __('live-editor.block.save') ?></button>
    <button v-on:click="showBlocksModal(0)" page-block-position="0" page-structure-action="add"></button>
</div>
