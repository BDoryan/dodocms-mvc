<?php

Autoloader::require('core/classes/Session.php');
Autoloader::require('core/classes/database/Database.php');
Autoloader::require('core/classes/i18n/Internationalization.php');
Autoloader::require("core/controllers/PanelController.php");
Autoloader::require("core/controllers/TableController.php");
Autoloader::require("core/classes/theme/Theme.php");

class Application
{

    public static Application $application;

    public static function get(): ?Application
    {
        return self::$application;
    }

    private Updater $updater;
    private Router $router;
    private Internationalization $internationalization;
    private Configuration $configuration;
    private ?Database $database = null;
    private Logger $logger;
    private Theme $theme;
    private JsonWebTokenManager $jwtManager;

    private bool $debugMode = false;
    private bool $showErrors = true;
    private string $root;
    private string $url;
    private array $vue_components = [];

    public function __construct(string $root = '', string $url = '')
    {
        $root = Tools::toURI($root);
        $url = Tools::toURI($url);

        $this->url = $url;
        $this->router = new Router($url);

        $this->setRoot($root);
        $this->logger = new Logger($this->toRoot("/cache/logs/" . "log-" . date("Y-m-d") . ".log"), $this->isDebugMode());

        self::$application = $this;
        $this->theme = new Theme("default");
    }

    public function getVueComponents(): array
    {
        return $this->vue_components;
    }

    public function addVueComponent(VueComponent $component)
    {
        $this->vue_components[] = $component;
    }

    public function removeVueComponent(VueComponent $component)
    {
        $this->vue_components = array_filter(
            $this->vue_components,
            function ($component_) use ($component) {
                return $component_ !== $component;
            }
        );
    }

    /**
     * Return all sections of the back office
     *
     * @return array
     */
    public function getSections(): array {
        return [
            new BlocksRoutes(),
            new PagesRoutes(),
            new ResourcesRoutes(),
            new TablesRoutes(),
            new ConfigurationsRoutes(),
            new UsersRoutes(),
            new BlocksRoutes(),
        ];
    }

    /**
     * @throws Exception
     */
    private function loadConfiguration()
    {
        $this->configuration = new Configuration($this->toRoot("/config/application"));
        $this->configuration->load();
    }

    private function loadAdminPanel()
    {
        DefaultRoutes::loadRoutes($this, $this->router);
        $this->logger->info("Routes initialized !");
    }

    private function loadSession()
    {
        if (isset($_GET["language"])) {
            Session::setLanguage($_GET["language"]);
        } else if (Session::getLanguage() == null) {
            Session::setLanguage(Internationalization::DEFAULT_LANGUAGE);
        }
        $this->logger->info("Session loaded !");
    }

    public function connectDatabase()
    {
        $this->database = Database::withConfiguration($this->getConfiguration());
        $this->database->connection();
        $this->logger->info("Connection to database success ! (".$this->getDatabase()->getName().")");
    }

    private function init()
    {
        $this->internationalization = new Internationalization(Session::getLanguage());
        $this->logger->info("Application initialized !");

        set_error_handler([$this, "errorHandler"]);
        set_exception_handler([$this, "exceptionHandler"]);
        $this->logger->info("Error and exception handler has been initialized !");
    }

    private function initVueComponents()
    {
        $this->addVueComponent(
            new VueComponent(
                $this->toRoot('/core/ui/views/admin/vue/resource-item.php'),
                $this->toURL('/core/assets/js/vue/ResourceItem.js')
            )
        );
        $this->addVueComponent(
            new VueComponent(
                $this->toRoot('/core/ui/views/admin/vue/resource-viewer.php'),
                $this->toURL('/core/assets/js/vue/ResourceViewer.js')
            )
        );
        $this->addVueComponent(
            new VueComponent(
                $this->toRoot('/core/ui/views/admin/vue/modal.php'),
            )
        );
        $this->addVueComponent(
            new VueComponent(
                $this->toRoot('/core/ui/views/admin/vue/resources/upload-modal.php'),
            )
        );
        $this->addVueComponent(
            new VueComponent(
                $this->toRoot('/core/ui/views/admin/vue/resources/resources-selector-modal.php'),
            )
        );
        $this->addVueComponent(
            new VueComponent(
                $this->toRoot('/core/ui/views/admin/vue/resources/resources.php'),
            )
        );
        $this->addVueComponent(
            new VueComponent(
                $this->toRoot('/core/ui/views/admin/vue/toast.php'),
            )
        );
        $this->addVueComponent(
            new VueComponent(
                $this->toRoot('/core/ui/views/admin/vue/blocks-modal.php'),
            )
        );
        $this->addVueComponent(
            new VueComponent(
                $this->toRoot('/core/ui/views/admin/vue/set-entry-modal.php'),
            )
        );
        $this->addVueComponent(
            new VueComponent(
                $this->toRoot('/core/ui/views/admin/vue/set-resource.php'),
            )
        );
    }

    public function errorHandler($errno, $errstr, $errfile, $errline): bool
    {
        view($this->toRoot("/core/ui/views/error.php"), [
            "errno" => $errno,
            "errmessage" => $errstr,
            "errfile" => $errfile,
            "errline" => $errline
        ]);

        return true;
    }

    public function exceptionHandler($exception)
    {
        view($this->toRoot("/core/ui/views/exception.php"), [
            'exception' => $exception,
        ]);
    }

    public function needSetup(): bool {
        return file_exists($this->toRoot("/setup")) && substr(DodoCMS::VERSION, 0, 11) != "development";
    }

    public function run()
    {
        if (isset($_GET["debug"])) {
            $this->setDebugMode(true);
        }

        $this->logger->info("Starting application...");
        $this->logger->debug("Application->run();");
        try {
            $this->logger->debug("Application->loadConfiguration();");
            $this->loadConfiguration();

            $this->logger->debug("Application->loadSession();");
            $this->loadSession();

            $this->logger->debug("Application->init();");
            $this->init();

            if($this->needSetup()) {
                Autoloader::require($this->toRoot('/setup'));
                Setup::run();
                return;
            }

            $this->logger->debug("Application->loadJWTManager()");
            $this->jwtManager = new JsonWebTokenManager($this->getConfiguration()["jwt"]["secret"], $this->getConfiguration()["jwt"]["expiresIn"]);

            $this->logger->debug("Application->connectDatabase();");
            $this->connectDatabase();

            if($this->getConfiguration()['modules']['enabled'] ?? false) {
                $this->logger->debug("Application->loadModules();");
                ModulesManager::loadModules();   
            } else {
                $this->logger->debug("(disabled) Application->loadModules();");
            }

            $this->logger->debug("Application->loadAdminPanel();");
            $this->loadAdminPanel();

            $this->logger->debug("Application->initVueComponents();");
            $this->initVueComponents();

            $this->updater = new DodoCMSUpdater();
            $this->logger->info("Updater initialized !");

            $this->logger->debug("Application->router->dispatch();");
            $this->logger->debug("dispatch();");
            if ($this->router->dispatch()) {
                $this->logger->debug($this->router->getRequestURI() . " has been dispatched !");
            } else {
                echo "404 Not Found !";
            }
            $this->database->closeConnection();
        } catch (Exception $e) {
            $this->logger->error('Application run error !');
            $this->logger->printException($e);
            $this->exception($e);
        } catch (Error $e) {
            $this->logger->error('Application run error !');
            $this->logger->printError($e);
            $this->error($e);
        }
    }

    /**
     * Get the view content
     *
     * @param $path string the path to the view (from the root)
     * @return void
     */
    public function fetch(string $path, array $args = []): string
    {
        return fetch($this->root . Tools::toURI($path), $args);
    }

    /**
     * Render the view
     *
     * @param $path string the path to the view (from the root)
     * @return void
     */
    public function view(string $path, array $args = [])
    {
        view($this->root . Tools::toURI($path), $args);
    }

    public function error($e): void
    {
        if (!$this->needShowErrors()) return;

        echo "<h1>Error on run !</h1>";
        echo "<pre>";
        echo $e->getMessage() . "\n";
        echo $e->getFile() . ":" . $e->getLine() . "\n";
        foreach ($e->getTrace() as $log) {
            echo $log["file"] . ":" . $log["line"] . "\n";
        }
        echo "</pre>";
        exit;

        $content = $this->fetch('/core/ui/views/ui/error.php', ['e' => $e]);
        $head = $this->fetch('/core/ui/views/admin/head.php', ['title' => __('error.title')]);
        $this->view('/core/ui/views/page/layout.php', ['head' => $head, 'content' => $content]);
    }

    public function exception($e): void
    {
        if (!$this->needShowErrors()) return;

        echo "<h1>Error on run !</h1>";
        echo "<pre>";
        echo $e->getMessage() . "\n";
        echo $e->getFile() . ":" . $e->getLine() . "\n";
        foreach ($e->getTrace() as $log) {
            echo $log["file"] . ":" . $log["line"] . "\n";
        }
        echo "</pre>";
        exit;

        $content = $this->fetch('/core/ui/views/ui/error.php', ['e' => $e]);
        $head = $this->fetch('/core/ui/views/admin/head.php', ['title' => __('error.title')]);
        $this->view('/core/ui/views/page/layout.php', ['head' => $head, 'content' => $content]);
    }

    public function showErrors(): void
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    public function getInternationalization(): ?Internationalization
    {
        return $this->internationalization;
    }

    public function redirect($to = '/')
    {
        header("Location: " . $this->toURL($to));
    }

    public function toURL(string $path): string
    {
        $url = $this->url . "/" . (trim($path, "/"));
        $url = preg_replace('#/{2,}#', '/', $url);
        $url = rtrim($url, '/');

        return $url;
    }

    /**
     * @param string $root
     */
    public function setRoot(string $root): void
    {
        $this->root = Tools::toURI($root);
    }

    public function toRoot(string $path): string
    {
        return $this->root . "/" . (trim($path, "/"));
    }

    public function setDebugMode(bool $debugMode): void
    {
        if (isset($this->logger))
            $this->logger->setDebug($debugMode);
        $this->debugMode = $debugMode;
    }

    public function isDebugMode(): bool
    {
        return $this->debugMode;
    }

    public function setShowErrors(bool $showErrors): void
    {
        $this->showErrors = $showErrors;
    }

    public function needShowErrors(): bool
    {
        return $this->showErrors;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function getDatabase(): Database
    {
        return $this->database;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function getRoot(): string
    {
        return $this->root;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTheme(): Theme
    {
        return $this->theme;
    }

    public function hasUpdate(): bool {
        $hasUpdate = Cache::get('DODOCMS_HAS_UPDATE');
        if($hasUpdate === null) {
            $hasUpdate = $this->updater->hasUpdate();
            Cache::set('DODOCMS_HAS_UPDATE', $hasUpdate);
        }
        return $hasUpdate;
    }

    public function setTheme(Theme $theme): void
    {
        $this->theme = $theme;
    }

    public function getConfigurationInstance(): Configuration {
        return $this->configuration;
    }

    public function getConfiguration(): array
    {
        return $this->configuration->get();
    }

    public function getJwtManager(): JsonWebTokenManager
    {
        return $this->jwtManager;
    }

    /**
     * @return Updater
     */
    public function getUpdater(): Updater
    {
        return $this->updater;
    }

    public function isDevelopment(): bool
    {
        return substr(DodoCMS::VERSION, 0, 11) == "development";
    }
}