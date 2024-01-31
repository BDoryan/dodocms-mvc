<?php

Autoloader::require('core/classes/controller/IDataController.php');

abstract class BlockController implements IDataController
{

    private int $block_id;

    public function __construct(int $block_id)
    {
        $this->block_id = $block_id;
    }

    public function getBlockId(): int
    {
        return $this->block_id;
    }

    /**
     * Set the data for the view of the block (override page data)
     */
    public abstract function data(): array;

}