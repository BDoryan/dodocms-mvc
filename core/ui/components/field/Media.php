<?php

Autoloader::require('core/ui/components/field/Field.php');

class Media extends Field
{

    private ?MediaModel $media;

    public function __construct(?MediaModel $media = null)
    {
        $this->media = $media;
    }

    public function media(MediaModel $media): Media
    {
        $this->media = $media;
        return $this;
    }

    public function render(): void
    {
        include "templates/components/fields/media.php";
    }

    public static function create(): Media
    {
        return new Media();
    }
}