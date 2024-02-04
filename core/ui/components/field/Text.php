<?php

Autoloader::require('core/ui/components/field/Field.php');

class Text extends Field
{
    private string $placeholder = '';
    private bool $useValidator = false;

    public function __construct(string $label = "", string $id = "", bool $required = false, string $name = "", string $value = "", string $placeholder = "")
    {
        parent::__construct($id);
        $this->label = $label;
        $this->id = empty($id) ? Tools::randomId("input") : $id;
        $this->required = $required;
        $this->name = $name;
        $this->value = $value;
        $this->type = "text";
        $this->placeholder = $placeholder;
    }

    public function validator(bool $useValidator = true): Text
    {
        $this->useValidator = $useValidator;
        return $this;
    }

    public function placeholder(string $placeholder): Text
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function render(): void
    {
        parent::render();

        include "$this->template/text.php";
    }

    public static function create(): Text
    {
        return new Text();
    }
}