<?php

Autoloader::require('core/classes/controller/IDataController.php');

abstract class StructureController implements IDataController
{

    private int $structure_id;

    public function __construct(int $structure_id)
    {
        $this->structure_id = $structure_id;
    }

    public function getStructureId(): int
    {
        return $this->structure_id;
    }

    /**
     * Set the data for the view of the block (override data of the page and blocks)
     */
    public abstract function data(): array;

}