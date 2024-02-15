<?php
/** @var VueComponent $component */
foreach (Application::get()->getVueComponents() as $component) {
    ?>
    <?= fetch($component->getTemplateFile()) ?>
    <?php if (!empty($component->getScript())) { ?>
        <script defer type="module" src="<?= $component->getScript() ?>"></script>
    <?php } ?>
<?php } ?>
