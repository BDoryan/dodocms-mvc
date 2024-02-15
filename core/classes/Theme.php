<?php

Autoloader::require("core/classes/Application.php");

class Theme
{

    private string $name;
    private string $root;
    private string $url;
    private ResourceManager $resourceManager;

    public function __construct(string $name)
    {
        $this->name = $name;

        $root = Application::get()->toRoot("/themes/" . $name);
        $url = Application::get()->toURL("/themes/" . $name);

        $this->resourceManager = new ResourceManager($url);

        if(Tools::endsWith($root, "/"))
            $root = substr($root, 0, strlen($root) - 1);

        if(Tools::endsWith($url, "/"))
            $url = substr($url, 0, strlen($url) - 1);

        $this->root = $root;
        $this->url = $url;
    }

    public function getResourceManager(): ResourceManager
    {
        return $this->resourceManager;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getRoot(): string
    {
        return $this->root;
    }

    public function toURL(string $path): string
    {
        if(Tools::startsWith($path, '/'))
            $path = substr($path, 1, strlen($path) - 1);
        return $this->getUrl() . "/" . $path;
    }

    public function toRoot(string $path): string
    {
        if(Tools::startsWith($path, '/'))
            $path = substr($path, 1, strlen($path) - 1);
        return $this->getRoot() . "/" . $path;
    }

    public function getAssets(): string
    {
        return $this->root . "/assets";
    }

    public function getViews(): string
    {
        return $this->root . "/views";
    }
}