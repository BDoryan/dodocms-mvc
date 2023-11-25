<?php

Autoloader::require("core/components/Component.php");

abstract class ButtonComponent extends Component
{

    protected string $text;

    public function __construct(string $text = '')
    {
        parent::__construct('core/views/components/button');
        $this->text = $text;
        $this->style('gray', 'white');
    }

    public function style(string $background_color, string $text_color, int $background_level = 700): ButtonComponent
    {
        $this->class = "bg-$background_color-$background_level hover:bg-$background_color-" . ($background_level + 100) . " text-$text_color px-3 py-2 rounded font-semibold uppercase";
        return $this;
    }

    public function green(int $background_level = 700): ButtonComponent
    {
        $this->style('green', 'white', $background_level);
        return $this;
    }

    public function red(int $background_level = 700): ButtonComponent
    {
        $this->style('red', 'white', $background_level);
        return $this;
    }

    public function blue(int $background_level = 700): ButtonComponent
    {
        $this->style('blue', 'white', $background_level);
        return $this;
    }

    public function text(string $text): ButtonComponent
    {
        $this->text = $text;
        return $this;
    }

    public function setClass(string $class): ButtonComponent
    {
        $this->class = $class;
        return $this;
    }

    public abstract function render();
}