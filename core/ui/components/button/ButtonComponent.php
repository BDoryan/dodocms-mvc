<?php

Autoloader::require("core/ui/components/Component.php");

abstract class ButtonComponent extends Component
{

    protected string $text;
    protected string $class;
    protected string $customClass = '';

    public function __construct(string $text = '')
    {
        parent::__construct('core/ui/views/components/button');
        $this->text = $text;
        $this->style('gray', 'white');
    }

    public function style(string $background_color, string $text_color, int $background_level = 700, $outline = false): ButtonComponent
    {
        $backgroundClass = $outline ? "dodocms-border-$background_color-500" : "dodocms-bg-$background_color-$background_level hover:dodocms-bg-$background_color-" . ($background_level + 100);
        $textClass = $outline ? "dodocms-text-$background_color-400 hover:dodocms-text-$background_color-500" : "dodocms-text-$text_color";

        $this->class = "$backgroundClass $textClass dodocms-text-center dodocms-px-3 dodocms-py-2 dodocms-rounded-lg dodocms-shadow-sm dodocms-font-semibold dodocms-uppercase" . $this->customClass;
        return $this;
    }

    /**
     *
     * Warning: For now, this method only works if you call it before the style() method.
     *
     * @param string $class
     * @return $this
     */
    public function addClass(string $class): ButtonComponent
    {
        if (substr($class, 0, 1) != ' ')
            $class = ' ' . $class;

        $this->customClass .= $class;
        return $this;
    }

    public function green(int $background_level = 700, $outline = false): ButtonComponent
    {
        $this->style('green', 'white', $background_level, $outline);
        return $this;
    }

    public function gray(int $background_level = 700, $outline = false): ButtonComponent
    {
        $this->style('gray', 'white', $background_level, $outline);
        return $this;
    }

    public function red(int $background_level = 700, $outline = false): ButtonComponent
    {
        $this->style('red', 'white', $background_level, $outline);
        return $this;
    }

    public function blue(int $background_level = 600, $outline = false): ButtonComponent
    {
        $this->style('blue', 'white', $background_level, $outline);
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