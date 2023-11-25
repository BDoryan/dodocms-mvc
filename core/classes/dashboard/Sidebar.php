<?php

class Sidebar
{

    private array $categories = [];

    /**
     * @param array $categories
     */
    public function __construct(array $categories)
    {
        $this->categories = $categories;
    }

    private function getSearch(string $href, array $sections): ?SidebarSection
    {
        $href = rtrim($href, '/');;
        /** @var SidebarSection $section */
        foreach ($sections as $section) {
            $section_href = rtrim($section->getHref(), '/');
            if ($section_href == $href) return $section;
            if (!empty($section->getSubsections())) {
                $find = $this->getSearch($href, $section->getSubsections());
                if ($find) return $find;
            }
        }
        return null;
    }

    public function getSectionByHref($href): ?SidebarSection
    {
        /** @var SidebarCategory $category */
        foreach ($this->categories as $category) {
            $section = $this->getSearch($href, $category->getSections());
            if ($section)
                return $section;
        }
        return null;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }
}