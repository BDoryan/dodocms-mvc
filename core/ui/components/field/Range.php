<?php

Autoloader::require('core/ui/components/field/Field.php');

class Range extends Field
{

    private int $min;
    private int $max;
    private int $step;

    public function __construct(string $id = "", int $min = 0, int $max = 100, $step = 1)
    {
        parent::__construct($id);
        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
    }

    public function getStep(): int
    {
        return $this->step;
    }

    public function setStep(int $step): void
    {
        $this->step = $step;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function setMin(int $min): void
    {
        $this->min = $min;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function setMax(int $max): void
    {
        $this->max = $max;
    }

    public function render(): void
    {
        parent::render();

        include "$this->template/range.php";
    }

    public static function create(): Range {
        return new Range();
    }
}