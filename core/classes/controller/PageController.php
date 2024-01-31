<?php

Autoloader::require('core/classes/controller/IDataController.php');

abstract class PageController implements IDataController
{

    private int $page_id;

    public function __construct(int $page_id)
    {
        $this->page_id = $page_id;
    }

    public function getPageId(): int
    {
        return $this->page_id;
    }

    /**
     * Handle the request
     *
     * @return void
     */
//    public abstract function handle(): void;

    /**
     * Set the data for the view of the page
     */
    public abstract function data(): array;

}