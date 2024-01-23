<?php

class ControllerManager
{

    private static array $controllers = [];

    public static function registerController($controller)
    {
        if ($controller instanceof BlockController) {
            self::$controllers['block'][$controller->getBlockId()] = $controller;
            return;
        }
        if ($controller instanceof StructureController) {
            self::$controllers['structure'][$controller->getStructureId()] = $controller;
            return;
        }
        if ($controller instanceof PageController) {
            self::$controllers['page'][$controller->getPageId()] = $controller;
            return;
        }
        if ($controller instanceof SectionController) {
            self::$controllers['panel']['section'][$controller->getSectionName()] = $controller;
            return;
        }
        throw new Exception('Controller must be an instance of BlockController, StructureController, PageController or SectionController');
    }

    public static function getSectionController(string $section_name): ?SectionController
    {
        return self::$controllers['panel']['section'][$section_name] ?? null;
    }

    public static function getSectionControllers(): array
    {
        return self::$controllers['panel']['section'] ?? [];
    }

    /**
     * Return the controller of the structure
     *
     * @param int $structure_id
     * @return StructureController|null
     */
    public static function getStructureController(int $structure_id): ?StructureController
    {
        return self::$controllers['structure'][$structure_id] ?? null;
    }

    /**
     * Return the controller of the block
     *
     * @param int $block_id
     * @return BlockController|null
     */
    public static function getBlockController(int $block_id): ?BlockController
    {
        return self::$controllers['block'][$block_id] ?? null;
    }

    /**
     * Return the controller of the page
     *
     * @param int $page_id
     * @return PageController|null
     */
    public static function getPageController(int $page_id): ?PageController
    {
        return self::$controllers['page'][$page_id] ?? null;
    }

    /**
     * Return all controllers registered
     *
     * @return array
     */
    public static function getControllers(): array
    {
        return self::$controllers;
    }
}