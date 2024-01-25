<div page-structure-actions>
    <?php
        Button::create()
        ->green()
            ->attribute('page-block-position', $position ?? '')
            ->attribute('page-structure-action', 'add')
            ->attribute('v-on:click', "showBlocksModal($position)" ?? '')
        ->render();
    ?>
</div>