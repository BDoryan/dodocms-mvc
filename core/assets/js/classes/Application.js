class Application  {

    static INSTANCE = null;

    static get() {
        return Application.INSTANCE;
    }

    constructor(root = '', language = 'en', api = '/api/') {
        this.root = root;
        this.api = api;
        this.runners = [];
        this.i18n = new Internationalization(language, this.toRoot('/core/translations/'));
        Application.INSTANCE = this;
    }

    getRoot() {
        return this.root;
    }

    addRunner(runner) {
        this.runners.push(runner);
    }

    async run() {
        await this.load();
        this.runners.forEach(runner => {
            runner();
        });
    }

    async load(){
        let r = await this.i18n.loadTranslations();
        return r;
    }

    getApi() {
        return this.api;
    }

    toRoot(path) {
        return this.root + path;
    }

    getI18n() {
        return this.i18n;
    }
}