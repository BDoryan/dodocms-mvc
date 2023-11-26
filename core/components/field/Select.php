<?php

Autoloader::require('core/components/field/Field.php');

class Select extends Field
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

    public function selected(string $value): Select
    {
        $this->value = $value;
        return $this;
    }

    public function options(array $options): Select
    {
        $this->options = $options;
        return $this;
    }

    public function undefinable(bool $undefinable): Select
    {
        $this->undefinable = $undefinable;
        return $this;
    }

    public function option(string $key, string $value): Select
    {
        $this->options[$key] = $value;
        return $this;
    }

    public function placeholder(string $placeholder): Select
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function render(): void
    {
        parent::render();

        include "$this->template/select.php";
    }

    public static function create(): Select
    {
        return new Select();
    }

    public static function toCombine(array $options, callable $callback): array {
        return array_combine($options, array_map($callback, $options));
    }
}