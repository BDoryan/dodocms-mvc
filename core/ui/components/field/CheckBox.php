<?php

Autoloader::require('core/ui/components/field/Field.php');

class CheckBox extends Field
{
    private string $placeholder = '';
    private bool $checked;

    public function __construct(string $label = "", string $id = "", bool $required = false, string $name = "", string $value = "", string $placeholder = "", bool $checked = false)
    {
        parent::__construct($id);
        $this->label = $label;
        $this->id = empty($id) ? Tools::randomId("input") : $id;
        $this->required = $required;
        $this->name = $name;
        $this->value = $value;
        $this->type = "checkbox";
        $this->placeholder = $placeholder;
        $this->checked = $checked;
    }

    public function value(string $value): Field
    {
        return $this->checked($value);
    }

    public function getValue(): string
    {
        return $this->checked;
    }

    public function checked(bool $checked): CheckBox
    {
        $this->checked = $checked;
        return $this;
    }

    public function placeholder(string $placeholder): CheckBox
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function render(): void
    {
        parent::render();

        include "$this->template/$this->type.php";
    }

    public static function create(): CheckBox
    {
        return new CheckBox();
    }
}