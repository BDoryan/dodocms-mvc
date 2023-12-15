<title><?= $title ?? '' ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
      integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
<link rel="icon" href="<?= Application::get()->toURL("/core/assets/favicon.png") ?>" sizes="32x32" type="image/png">
<link rel="stylesheet" href="<?= Application::get()->toURL("/core/assets/css/tailwind.css") ?>">

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script defer src="<?= Application::get()->toURL("/core/assets/js/scripts/ckeditor.init.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/classes/FormUtils.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/classes/Internationalization.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/classes/Application.js") ?>"></script>

<script>
    DODOCMS_APPLICATION = new Application('<?= Application::get()->getUrl() ?>', '<?= Application::get()->getInternationalization()->getLanguage() ?>', '<?= Application::get()->toURL("/admin/api/") ?>');
</script>
<script type="module" src="<?= Application::get()->toURL("/core/assets/js/modules/select.js") ?>"></script>
<script type="module" src="<?= Application::get()->toURL("/core/assets/js/modules/resources/upload.js") ?>"></script>
<script type="module" src="<?= Application::get()->toURL("/core/assets/js/modules/resources/selector.js") ?>"></script>
<script type="module" src="<?= Application::get()->toURL("/core/assets/js/init.js") ?>"></script>

<!-- Load vue.js -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

<!-- Load all vue components -->
<?php
    /** @var VueComponent $component */
    foreach (Application::get()->getVueComponents() as $component) {
 ?>
<?= fetch($component->getTemplateFile()) ?>
<script defer src="<?= $component->getScript() ?>"></script>
<?php } ?>

<!-- Load vue.js app -->
<script defer src="<?= Application::get()->toURL("core/assets/js/vue/app.js") ?>"></script>