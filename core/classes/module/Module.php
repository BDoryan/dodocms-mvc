<?php
abstract class Module
{

    private string $name;
    private string $description;
    private string $version;
    private string $author;
    private string $website;
    private string $license;
    private string $icon;

    /**
     * @param string $name
     * @param string $description
     * @param string $version
     * @param string $author
     * @param string $website
     * @param string $license
     * @param string $icon
     */
    public function __construct(string $name, string $description, string $version, string $author, string $website, string $license, string $icon)
    {
        $this->name = $name;
        $this->description = $description;
        $this->version = $version;
        $this->author = $author;
        $this->website = $website;
        $this->license = $license;
        $this->icon = $icon;
    }

    /**
     * Method called when the module is installed
     *
     * @return void
     */
    public abstract function install(): void;

    /**
     * Method called when the module is loaded
     *
     * @return void
     */
    public abstract function load(): void;

    /**
     * Method called when the module is uninstalled
     *
     * @return void
     */
    public abstract function uninstall(): void;

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