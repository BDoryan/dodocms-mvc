<?php

class HelloWorldModule extends Module
{

    public function __construct()
    {
        parent::__construct(
             __DIR__,
            "HelloWorld",
            "",
            "1.0.0",
            "Doryan BESSIERE",
            "https://www.doryanbessiere.fr/",
            "",
            "fa-solid fa-cubes"
        );
    }

    public function getRoutes(): array
    {
        return [
            new HelloWorldRoutes($this)
        ];
    }

    public function getSidebarSection(): SidebarSection
    {
        return new SidebarSection("dodocms-me-1 fa-solid ".$this->getIcon(), $this->getName(), DefaultRoutes::ADMIN_PANEL.'/test');
    }

    public function installModule(): void
    {
    }

    public function loadModule(): void
    {
        parent::loadModule();
        Application::get()->getLogger()->info('Hello World !');
    }

    public function uninstallModule(): void
    {

    }
}