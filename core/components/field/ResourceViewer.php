<?php

Autoloader::require('core/components/field/Field.php');

class ResourceViewer extends Field
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

    public function multiple(bool $multiple = true): ResourceViewer {
        $this->multiple = $multiple;
        return $this;
    }

    public function resources(array $resources): ResourceViewer {
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

    public function resourceToJson() {
        foreach ($this->resources as $resource) {
            $resource->setSrc($resource->getSrc());
        }
        return json_encode($this->resources, JSON_HEX_QUOT);
    }

    public function render(): void
    {
        parent::render();

        include "$this->template/resources/resources-viewer.php";
    }

    /**
     * @return array
     */
    public function getMedias(): array
    {
        return $this->resources;
    }

    public static function create(): ResourceViewer
    {
        return new ResourceViewer();
    }
}