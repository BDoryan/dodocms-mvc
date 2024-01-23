<!-- ## DodoCMS ## -->
<!-- Here you can found all scripts and styles required for use the CMS -->

<!-- Load Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
      integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>

<!-- Load TailwindCSS -->
<link rel="stylesheet" href="<?= Application::get()->toURL("/core/admin/assets/css/global.css") ?>">

<!-- Load JavaScript libs -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<!-- Load JavaScript classes -->
<script src="<?= Application::get()->toURL("/core/admin/assets/js/classes/Toast.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/admin/assets/js/classes/FormUtils.js") ?>"></script>

<!-- Load dodocms scripts -->
<script defer src="<?= Application::get()->toURL("/core/admin/assets/js/scripts/ckeditor.init.js") ?>"></script>
<script defer src="<?= Application::get()->toURL("/core/admin/assets/js/scripts/live-editor.init.js") ?>"></script>

<!-- Load dodocms modules -->
<script type="module" src="<?= Application::get()->toURL("/core/admin/assets/js/scripts/select.js") ?>"></script>

<!-- Application for JavaScript -->
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

<!-- Load vue.js application -->
<script defer src="<?= Application::get()->toURL("core/admin/assets/js/vue/app.js") ?>"></script>