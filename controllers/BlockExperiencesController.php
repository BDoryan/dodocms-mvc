<?php
class BlockExperiencesController extends BlockController
{
    public function __construct()
    {
        parent::__construct(10);
    }


    public function data(): array
    {
        return [
            'experiences' => ExperiencesModel::findAll('*', ['active' => 1])
        ];
    }
}

ControllerManager::registerController(new BlockExperiencesController());