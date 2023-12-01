<?php

Autoloader::require('core/components/field/Field.php');

class ResourceSelector extends Field
{

    private array $resources;

    public function __construct(array $resources = [])
    {
        parent::__construct();
        $this->resources = $resources;
    }

    public function resources(array $resources): ResourceSelector {
        $this->resources = $resources;
        return $this;
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