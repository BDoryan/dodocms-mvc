<div liveeditor-bar>
    <img class="dodocms-logo" src="<?= Application::get()->toURL('core/assets/imgs/logo.png') ?>" alt="DodoCMS">
    <?php
    Button::create()
        ->text(__('live-editor.block.save'))
        ->addClass("dodocms-shadow-lg")
        ->green()
        ->attribute('liveeditor-action', 'add')
        ->render()
    ?>
    <?php
    Button::create()
        ->green()
        ->attribute('v-on:click', 'showBlocksModal(0)')
        ->attribute('page-block-position', '0')
        ->attribute('page-structure-action', 'add')
        ->render()
    ?>
</div>
