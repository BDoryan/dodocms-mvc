<?php

Autoloader::require('core/ui/components/field/Field.php');

class CKEditor extends Field
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

    public function validator(bool $useValidator = true): CKEditor
    {
        $this->useValidator = $useValidator;
        return $this;
    }

    public function placeholder(string $placeholder): CKEditor
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function rows(int $rows): CKEditor
    {
        $this->rows = $rows;
        return $this;
    }

    public function render(): void
    {
        parent::render();

        include "$this->template/ckeditor.php";
    }

    public static function create(): CKEditor
    {
        return new CKEditor();
    }
}