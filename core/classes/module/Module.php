<?php
abstract class Module
{

    private string $root;
    private string $name;
    private string $description;
    private string $version;
    private string $author;
    private string $website;
    private string $license;
    private string $icon;

    /**
     * @param string $root
     * @param string $name
     * @param string $description
     * @param string $version
     * @param string $author
     * @param string $website
     * @param string $license
     * @param string $icon
     */
    public function __construct(string $root, string $name, string $description, string $version, string $author, string $website, string $license, string $icon)
    {
        $this->root = $root;
        $this->name = $name;
        $this->description = $description;
        $this->version = $version;
        $this->author = $author;
        $this->website = $website;
        $this->license = $license;
        $this->icon = $icon;
    }

    /**
     * List of routes classes to load
     *
     * @return array
     */
    public abstract function getRoutes(): array;

    /**
     * List of controllers classes to load
     *
     * @return SidebarSection
     */
    public abstract function getSidebarSection(): SidebarSection;

    public function loadTranslations(): void
    {
        $language_file = $this->getRoot() . '/translations/' . Application::get()->getInternationalization()->getLanguage() . '.json';
        if (!file_exists($language_file))
            $language_file = $this->getRoot() . '/translations/en.json';
        $translations = json_decode(file_get_contents($language_file), true);
        Application::get()->getInternationalization()->addTranslations($translations);
    }

    public function loadRoutes(): void {
        $routes = $this->getRoutes();
        /** @var Routes $route */
        foreach ($routes as $route) {
            $route->routes(Application::get()->getRouter());
        }
        Application::get()->getLogger()->debug('Routes loaded ' . $this->getName());
    }

    /**
     * Method called when the module is installed
     *
     * @return void
     */
    public abstract function installModule(): void;

    /**
     * Method called when the module is loaded
     *
     * @return void
     */
    public function loadModule(): void {
        $this->loadTranslations();
        $this->loadRoutes();
    }

    /**
     * Method called when the module is uninstalled
     *
     * @return void
     */
    public abstract function uninstallModule(): void;

    public function toRoot(string $path): string
    {
        if (substr($path, 0, 1) !== '/')
            $path = '/' . $path;
        return $this->getRoot() . $path;
    }

    /**
     * Return the root of the module
     *
     * @return string
     */
    public function getRoot(): string
    {
        return $this->root;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getLicense(): string
    {
        return $this->license;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }
}