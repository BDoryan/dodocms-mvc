class Internationalization {

    static DEFAULT_TRANSLATIONS;
    static DEFAULT_LANGUAGE = "en";

    constructor(language, root = '/core/translations/') {
        this.language = language;
        this.root = root;
        this.translations = {};

        this.setRoot(this.root);
    }

    async loadTranslations() {
        const path = this.getRoot() + this.language + '.json';

        try {
            const response = await $.ajax({
                url: path,
                dataType: 'json',
            });
            this.translations = response;
            return true;
        } catch (error) {
            console.error(error);
            throw new Error('Failed to load translations');
        }
        return false;
    }

    getTranslate(key) {
        if (this.translations[key]) {
            return this.translations[key];
        }

        if (this.language === Internationalization.DEFAULT_LANGUAGE) {
            return key;
        }

        if (!Internationalization.DEFAULT_TRANSLATION) {
            Internationalization.DEFAULT_TRANSLATION = new Internationalization(Internationalization.DEFAULT_LANGUAGE);
        }

        return Internationalization.DEFAULT_TRANSLATION.getTranslate(key) || key;
    }

    translate(key, options = {}) {
        let translation = this.getTranslate(key);
        for (const [k, v] of Object.entries(options)) {
            translation = translation.replace(new RegExp(`{${k}}`, 'g'), v);
        }
        return translation;
    }

    setRoot(root) {
        this.root = this.toURI(root);
    }

    getRoot() {
        return this.root;
    }

    getLanguage() {
        return this.language;
    }

    getTranslations() {
        return this.translations;
    }

    toURI(root) {
        return root.endsWith('/') ? root : root + '/';
    }
}
