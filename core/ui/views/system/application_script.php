<script>
    const translations_json = '<?= str_replace("'", "\'", json_encode(Application::get()->getInternationalization()->getTranslations())) ?>';
    const translations = JSON.parse(translations_json);

    const root = '<?= Application::get()->toURL("/") ?>';

    window.toRoot = (path) => {
        return root + path;
    }

    <?php if(Session::authenticated() ?? false) { ?>
    const admin_path = '<?= Application::get()->toURL("/" . Application::get()->getConfigurationInstance()->get('admin_path') . "/") ?>';
    const api = '<?= Application::get()->toURL("/" . Application::get()->getConfigurationInstance()->get('admin_path') . "/api/") ?>';

    window.toApi = (path) => {
        return api + path;
    }

    window.toAdminPath = (path) => {
        return admin_path + path;
    }
    <?php } ?>

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