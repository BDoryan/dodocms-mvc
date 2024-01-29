<?php
class BlockProjectsController extends BlockController
{
    public function __construct()
    {
        parent::__construct(11);
    }


    public function data(): array
    {
        return [
            'projects' => ProjectsModel::findAll('*', ['active' => 1])
        ];
    }
}

ControllerManager::registerController(new BlockProjectsController());