<?php

Autoloader::require('core/ui/components/field/Field.php');

class MediaSelector extends Field
{

    private array $medias;

    public function __construct(array $medias = [])
    {
        parent::__construct();
        $this->medias = $medias;
    }

    public function medias(array $medias): MediaSelector
    {
        $this->medias = $medias;
        return $this;
    }

    public function render(): void
    {
        parent::render();

        include "templates/components/fields/media-selector/media-selector.php";
    }

    /**
     * @return array
     */
    public function getMedias(): array
    {
        return $this->medias;
    }

    public static function create(): MediaSelector
    {
        return new MediaSelector();
    }
}