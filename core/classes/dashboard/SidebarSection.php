<?php

class SidebarSection
{


    private string $icon;
    private string $label;
    private string $href;
    private array $subsections;
    private bool $active = false;

    public function __construct(string $icon, string $label, string $href, array $subsections = [])
    {
        $this->icon = $icon;
        $this->label = $label;
        $this->href = $href;
        $this->subsections = $subsections;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    public function getSubsections(): array
    {
        return $this->subsections;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getHref(): string
    {
        return $this->href;
    }
}