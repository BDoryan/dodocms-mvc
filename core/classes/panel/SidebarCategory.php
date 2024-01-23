<?php

class SidebarCategory
{

    private string $label;
    private array $sections = [];

    /**
     * @param string $label
     * @param array $sections
     */
    public function __construct(string $label, array $sections)
    {
        $this->label = $label;
        $this->sections = $sections;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getSections(): array
    {
        return $this->sections;
    }

    public function setSections(array $sections): void
    {
        $this->sections = $sections;
    }
}