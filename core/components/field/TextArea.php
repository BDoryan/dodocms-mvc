<?php

Autoloader::require('core/components/field/Field.php');

class TextArea extends Field
{
    private string $placeholder = '';
    private bool $useValidator = false;
    private int $rows = 5;

    public function __construct(string $label = "", string $id = "", bool $required = false, string $name = "", string $value = "", string $placeholder = "", $rows = 5)
    {
        parent::__construct($id);
        $this->label = $label;
        $this->id = empty($id) ? Tools::randomId("input") : $id;
        $this->required = $required;
        $this->name = $name;
        $this->value = $value;
        $this->type = "text";
        $this->placeholder = $placeholder;
        $this->rows = $rows;
    }

    public function validator(bool $useValidator): TextArea
    {
        $this->useValidator = $useValidator;
        return $this;
    }

    public function placeholder(string $placeholder): TextArea
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function rows(int $rows): TextArea
    {
        $this->rows = $rows;
        return $this;
    }

    public function render(): void
    {
        parent::render();

        include "$this->template/textarea.php";
    }

    public static function create(): TextArea
    {
        return new TextArea();
    }
}