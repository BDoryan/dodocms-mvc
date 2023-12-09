<?php

Autoloader::require('core/components/field/Field.php');

class ResourceSelector extends Field
{

    private array $resources;
    private bool $multiple = false;

    public function __construct(array $resources = [], bool $multiple = false)
    {
        parent::__construct();
        $this->resources = $resources;
        $this->multiple = $multiple;
    }

    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    public function multiple(bool $multiple = true): ResourceSelector {
        $this->multiple = $multiple;
        return $this;
    }

    public function resources(array $resources): ResourceSelector {
        $this->resources = $resources;
        return $this;
    }

    public function resourcesToString(): string
    {
        $string = "";
        foreach ($this->resources as $resource) {
            $string .= $resource->getId() . ",";
        }
        return substr($string, 0, -1);
    }

    public function render(): void
    {
        parent::render();

        include "$this->template/resources/resources-selector.php";
    }

    /**
     * @return array
     */
    public function getMedias(): array
    {
        return $this->resources;
    }

    public static function create(): ResourceSelector
    {
        return new ResourceSelector();
    }
}