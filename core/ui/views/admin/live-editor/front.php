<div liveeditor-bar>
    <img class="dodocms-logo" src="<?= Application::get()->toURL('core/assets/imgs/logo.png') ?>" alt="DodoCMS">
    <?php
    if (empty($editor))
        $editor = false;

    if($editor) {
        Button::create()
            ->text('<i class="fa-solid fa-save" style="padding-right: 8px;"></i>'.__('live-editor.block.save'))
            ->addClass("tw-shadow-lg")
            ->green()
            ->attribute('liveeditor-action', 'add')
            ->render();
    }
    ButtonHypertext::create()
        ->text('<i class="fa-solid fa-pen" style="padding-right: 8px;"></i>'.(!$editor ? __('live-editor.toggle_on_editor') : __('live-editor.toggle_off_editor')))
        ->addClass("tw-shadow-lg")
        ->style(!$editor ? ButtonComponent::BUTTON_GREEN : ButtonComponent::BUTTON_RED)
        ->href('?editor='.(!$editor ? 'true' : 'false'))
        ->render();
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
