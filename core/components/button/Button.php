<?php

Autoloader::require("core/components/button/ButtonComponent.php");

class Button extends ButtonComponent
{

    protected string $type = 'button';

    public function __construct(string $text = '')
    {
        parent::__construct($text);
    }

    public function type(string $type): Button
    {
        $this->type = $type;
        return $this;
    }

    public function render()
    {
        include "$this->template/button.php";
    }

    public static function create(): Button
    {
        return new Button();
    }
}