<?php


Autoloader::require("core/interfaces/IRenderer.php");

abstract class Component implements IRenderer
{

    protected string $id;
    protected string $template;
    protected array $attributes = [];
    protected bool $disabled = false;

    public function __construct($template = 'core/views/components', $id = '')
    {
        $this->template = Application::get()->toRoot($template);
        $this->id = empty($id) ? Tools::randomId("input") : $id;
    }

    public function id(string $id): Component
    {
        $this->id = $id;
        return $this;
    }

    public function disabled(bool $disabled = true): Component
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function template(string $template): Component
    {
        $template = Tools::removeLastSlash($template);
        $template = Tools::addFirstSlash($template);
        $this->template = Application::get()->toRoot($template);
        return $this;
    }

    public function attribute(string $name, string $value): Component
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function attributes(): string
    {
        if (empty($this->attributes))
            return '';

        $attributes = '';
        foreach ($this->attributes as $key => $value) {
            $attributes .= "$key=\"$value\" ";
        }

        $attributes = rtrim($attributes);
        return $attributes;
    }

    public function html(): string
    {
        ob_start();
        $this->render();
        return ob_get_clean();
    }

    public abstract function render();

}