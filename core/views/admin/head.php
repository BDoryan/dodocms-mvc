<title><?= $title ?? '' ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
      integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
<link rel="icon" href="<?= Application::get()->toURL("/core/assets/favicon.png") ?>" sizes="32x32" type="image/png">

<!-- Load TailwindCSS -->
<link rel="stylesheet" href="<?= Application::get()->toURL("/core/assets/css/tailwind.css") ?>">

<!-- Load JavaScript libs -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script defer src="<?= Application::get()->toURL("/core/assets/js/scripts/ckeditor.init.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/classes/FormUtils.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/classes/Internationalization.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/classes/Application.js") ?>"></script>

<script>
    //DODOCMS_APPLICATION = new Application('<?php //= Application::get()->getUrl() ?>//', '<?php //= Application::get()->getInternationalization()->getLanguage() ?>//', '<?php //= Application::get()->toURL("/admin/api/") ?>//');
</script>

<!-- Translations for JavaScript -->
<script>
    const translations_json = '<?= str_replace("'", "\'", json_encode(Application::get()->getInternationalization()->getTranslations())) ?>';
    const translations = JSON.parse(translations_json);

    const root = '<?= Application::get()->toURL("/") ?>';
    const api = '<?= Application::get()->toURL("/admin/api/") ?>';

    window.toRoot = (path) => {
        return root + path;
    }

    window.toApi = (path) => {
        return api + path;
    }

    window.getTranslate = (key) => {
        if (translations[key]) {
            return translations[key];
        }

        return key;
    }

    window.translate = (key, options = {}) => {
        let translation = getTranslate(key);
        for (const [k, v] of Object.entries(options)) {
            translation = translation.replace(new RegExp(`{${k}}`, 'g'), v);
        }
        return translation;
    }
</script>

<!-- Load all modules -->
<script type="module" src="<?= Application::get()->toURL("/core/assets/js/scripts/select.js") ?>"></script>
<!--<script type="module" src="--><?php //= Application::get()->toURL("/core/assets/js/init.js") ?><!--"></script>-->

<!-- Load vue.js -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script src="https://unpkg.com/vuex@4.1.0/dist/vuex.global.js"></script>

<!-- Load all vue components -->
<?php
/** @var VueComponent $component */
foreach (Application::get()->getVueComponents() as $component) {
    ?>
    <?= fetch($component->getTemplateFile()) ?>
    <?php if (!empty($component->getScript())) { ?>
        <script defer type="module" src="<?= $component->getScript() ?>"></script>
    <?php } ?>
<?php } ?>

<!-- Load vue.js app -->
<script defer src="<?= Application::get()->toURL("core/assets/js/vue/app.js") ?>"></script>