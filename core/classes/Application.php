<?php

Autoloader::require('core/classes/Session.php');
Autoloader::require('core/classes/database/Database.php');
Autoloader::require('core/classes/i18n/Internationalization.php');

class Application
{

    public static Application $application;

    public static function get(): ?Application
    {
        return self::$application;
    }

    private bool $debugMode = true;
    private bool $showErrors = true;
    private string $root;
    private string $url;
    private Router $router;
    private Internationalization $internationalization;
    private Configuration $configuration;
    private Database $database;
    private Logger $logger;

    public function __construct(string $root = '', string $url = '')
    {
        $root = Tools::toURI($root);
        $url = Tools::toURI($url);

        $this->url = $url;
        $this->router = new Router($url);

        $this->setRoot($root);
        $this->logger = new Logger($this->toRoot("/logs/"."log-".date("Y-m-d_H-m-s").".log"), $this->isDebugMode());

        self::$application = $this;
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
        $adminController = new PanelController();
        $this->router->get(Routes::ADMIN_PANEL, [$adminController, 'index']);
        $this->router->get(Routes::ADMIN_LOGIN, [$adminController, 'login']);
        $this->router->post(Routes::ADMIN_LOGIN, [$adminController, 'authentication']);
        $this->router->get(Routes::ADMIN_PANEL . "/{section}", [$adminController, 'section']);
    }

    private function loadSession()
    {
        if (isset($_GET["language"])) {
            Session::setLanguage($_GET["language"]);
        } else if (Session::getLanguage() == null) {
            Session::setLanguage(Internationalization::DEFAULT_LANGUAGE);
        }
    }

    private function loadDatabase()
    {
        $database = Database::withConfiguration($this->getConfiguration());
        $database->connection();
    }

    private function init()
    {
        $this->internationalization = new Internationalization(Session::getLanguage());

        if (isset($_GET["debug"])) {
            $this->setDebugMode(true);
        }
    }

    public function run()
    {
        $this->logger->info("Starting application...");
        $this->logger->debug("Application->run();");
        try {
            $this->logger->debug("Application->loadConfiguration();");
            $this->loadConfiguration();
            $this->logger->debug("Application->loadDatabase();");
            $this->loadDatabase();
            $this->logger->debug("Application->loadSession();");
            $this->loadSession();
            $this->logger->debug("Application->init();");
            $this->init();
            $this->logger->debug("Application->loadAdminPanel();");
            $this->loadAdminPanel();

            $this->logger->debug("dispatch();");
            if ($this->router->dispatch()) {

            } else {
                echo "404 Not Found !";
            }
//            $this->database->closeConnection();
        } catch (Exception $e) {
            echo "Application run exception !";
            $this->error($e);
        } catch (Error $e) {
            echo "Application run error !";
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

    public function error(Error $e): void
    {
        if (!$this->needShowErrors()) return;

        $content = $this->fetch('/core/views/error.php', ['e' => $e]);
        $head = $this->fetch('/core/views/admin/head.php', ['title' => __('error.title')]);
        $this->view('/core/views/page/layout.php', ['head' => $head, 'content' => $content]);
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
        return $this->url . "/" . (trim($path, "/"));
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

    public function getConfiguration(): array
    {
        return $this->configuration->get();
    }
}