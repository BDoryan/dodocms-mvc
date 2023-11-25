<?php

Autoloader::require('core/components/field/Field.php');

class Dropdown extends Field
{

    private bool $undefinable = false;
    private string $placeholder = '';
    private array $options = [];

    public function __construct(string $label = "", string $id = "", bool $required = false, string $name = "", string $value = "", string $placeholder = "")
    {
        parent::__construct($id);
        $this->label = $label;
        $this->id = empty($id) ? Tools::randomId("input") : $id;
        $this->required = $required;
        $this->name = $name;
        $this->value = $value;
        $this->type = "select";
        $this->placeholder = $placeholder;
    }

    public function selected(string $value): Dropdown
    {
        $this->value = $value;
        return $this;
    }

    public function options(array $options): Dropdown
    {
        $this->options = $options;
        return $this;
    }

    public function undefinable(bool $undefinable): Dropdown
    {
        $this->undefinable = $undefinable;
        return $this;
    }

    public function option(string $key, string $value): Dropdown
    {
        $this->options[$key] = $value;
        return $this;
    }

    public function placeholder(string $placeholder): Dropdown
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function render(): void
    {
        parent::render();

        include "$this->template/dropdown.php";
    }

    public static function create(): Dropdown
    {
        return new Dropdown();
    }
}