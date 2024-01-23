<?php

Autoloader::require('core/classes/controller/IController.php');

abstract class Controller implements IController
{

    protected string $root;
    protected string $name;
    protected string $layout;
    protected string $assets;
    protected string $content = '';

    public function __construct(string $name, string $root, string $asset = '/', string $layout = null)
    {
        $this->name = $name;
        $this->layout = $layout;

        $this->setRoot($root);
        $this->setAssets($asset);
    }

    /**
     * @param string $root
     */
    public function setRoot(string $root): void
    {
        $this->root = Tools::toURI($root);
    }

    /**
     * @param string $assets
     */
    public function setAssets(string $assets): void
    {
        $this->assets = Tools::toURI($assets);
    }

    /**
     * @param string $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = Tools::toURI($layout);
    }

    public function layout($data = [])
    {
        if (!empty($this->layout)) {
            view($this->root . Tools::toURI($this->layout . '.php'), $data);
            return;
        }
        echo $this->content;
    }

    public function __($key, $options = []): string
    {
        return Application::get()->getInternationalization()->translate($key, $options);
    }

    public function redirect($to)
    {
        $this->getApplication()->redirect($to);
    }

    public function fetch($path, $data = []): string
    {
        return fetch($this->root . Tools::toURI($path) . '.php', $data);
    }

    public function view($view, array $data = []): void
    {
        $this->content .= $this->fetch($view, $data);
        if(empty($this->layout)) {
            echo $this->content;
            return;
        }

        $path = $this->root . Tools::toURI($this->layout) . '.php';
        $data['content'] = $this->content;
        view($path, $data);
    }

    public function addContent($content): void
    {
        $this->addHTML($content);
    }

    public function addHTML($html): void
    {
        $this->content .= $html;
    }

    public function getApplication(): Application
    {
        return Application::get();
    }

    public function toRoot($path): string
    {
        return $this->getApplication()->toRoot($path);
    }

    public function toURL($path): string
    {
        return $this->getApplication()->toURL($path);
    }

    public function toAsset($path): string
    {
        return $this->getApplication()->toURL($this->assets . '/' . $path);
    }
}