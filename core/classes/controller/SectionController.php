<?php

abstract class SectionController extends PanelController
{

    private string $section_name;

    public function __construct(string $section_name)
    {
        parent::__construct();
        $this->section_name = $section_name;
    }

    /**
     * @return string
     */
    public function getSectionName(): string
    {
        return $this->section_name;
    }
}