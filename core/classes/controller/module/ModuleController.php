<?php

abstract class ModuleController extends PanelController
{

    private Module $module;

    public function __construct(Module $module)
    {
        parent::__construct();
        $this->module = $module;
    }

    public function view(string $view, array $data = []): void
    {
        if (substr($view, 0, 1) === "/")
            $view = substr($view, 1);

        Application::get()->getLogger()->debug("PanelController->initSidebar()");
        $this->initSidebar();

        $this->title = 'DodoCMS - ' . __('admin.panel.dashboard');

        $alerts =  $this->getAlerts();
        Application::get()->getLogger()->debug("AdminController->getAlerts() : " . (var_export($alerts, true)));

        $data['alerts'] = $alerts;
        $section = fetch($this->module->toRoot('views/'.$view.".php"), $data);

        parent::view('panel/layout', [
                'sidebar' => $this->sidebar,
                'content' => $section
            ]
        );
    }

    /**
     * @return Module
     */
    public function getModule(): Module
    {
        return $this->module;
    }
}