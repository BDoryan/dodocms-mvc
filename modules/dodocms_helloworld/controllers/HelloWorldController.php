<?php

class HelloWorldController extends ModuleController
{

    public function __construct(Module $module)
    {
        parent::__construct($module);
    }

    public function index(): void
    {
        $this->view("helloworld");
    }
}