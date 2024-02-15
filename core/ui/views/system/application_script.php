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