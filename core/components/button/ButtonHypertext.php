<?php

class ButtonHypertext extends ButtonComponent
{

    protected string $href = '';

    public function __construct(string $text = '')
    {
        parent::__construct($text);
    }

    public function href(string $href): ButtonHypertext
    {
        $this->href = $href;
        return $this;
    }

    public function render()
    {
        include "$this->template/button-hypertext.php";
    }

    public static function create(): ButtonHypertext
    {
        return new ButtonHypertext();
    }
}