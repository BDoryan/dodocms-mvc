<?php
class BlockServicesController extends BlockController
{
    public function __construct()
    {
        parent::__construct(5);
    }


    public function data(): array
    {
        return [
            'services' => ServicesModel::findAll('*', ['active' => 1])
        ];
    }
}

ControllerManager::registerController(new BlockServicesController());