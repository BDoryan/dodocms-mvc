<?php

Autoloader::require('core/classes/IRenderer.php');

abstract class Field extends Component
{

    protected string $template;
    protected array $parameters = [];
    protected bool $required = false;

    protected string $label;
    protected string $name;
    protected string $value;
    protected string $type;
    protected bool $readonly = false;

    public function __construct($id = "")
    {
        parent::__construct('core/ui/views/components/field', $id);
    }


    public function disabled(bool $disabled = true): Field
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function label(string $label): Field
    {
        $this->label = $label;
        return $this;
    }

    public function required(bool $required = true): Field
    {
        $this->required = $required;
        return $this;
    }

    public function readonly(bool $readonly = true): Field
    {
        $this->readonly = $readonly;
        return $this;
    }

    public function parameters(array $parameters): Field
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function name(string $name): Field
    {
        $this->name = $name;
        return $this;
    }

    public function value(string $value): Field
    {
        $this->value = $value;
        return $this;
    }

    public function type(string $type): Field
    {
        $this->type = $type;
        return $this;
    }

    public function parameter(string $key, $value): Field
    {
        $this->options[$key] = $value;
        return $this;
    }

    public function removeOption(string $key): Field
    {
        unset($this->options[$key]);
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function render(): void
    {
        if (!empty($this->label)) {
            include $this->template . '/label.php';
        }
    }
}