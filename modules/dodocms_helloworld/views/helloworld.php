<h1><?= __('doryanbessiere.fr.hello') ?></h1>
<p class="dodocms-mb-2"><?= __('Bienvenue') ?></p>
<?php
Text::create()
    ->name('name')
    ->required()
    ->render()
?>