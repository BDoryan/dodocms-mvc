<?php
class BlockSkillsController extends BlockController
{
    public function __construct()
    {
        parent::__construct(13);
    }


    public function data(): array
    {
        return [
            'skills' => SkillModel::findAll('*', ['active' => 1])
        ];
    }
}

ControllerManager::registerController(new BlockSkillsController());