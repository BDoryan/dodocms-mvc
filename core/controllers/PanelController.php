<?php

Autoloader::require('core/controllers/DOMController.php');
Autoloader::require('core/controllers/AdminController.php');

class PanelController extends AdminController
{

    private Sidebar $sidebar;

    public function __construct()
    {
        parent::__construct('admin', $this->toRoot('/core/views'), 'core/assets/', 'head');
    }

    public function initSidebar()
    {
        $this->sidebar = new Sidebar([
            new SidebarCategory(__("admin.panel.content_manager"), [
            ]),
            new SidebarCategory(__("admin.panel.admin_center"), [
            ]),
            new SidebarCategory(__("admin.panel.developer_center"), [
                new SidebarSection("fa-solid fa-layer-group", __('admin.panel.table_management'), Routes::ADMIN_TABLES, [
                    new SidebarSection("fa-solid fa-layer-group", __('admin.panel.table_management.new'), Routes::ADMIN_TABLES_NEW),
                ]),
            ])
        ]);

        $url = Application::get()->getRouter()->getRequestURI();
        $section = $this->sidebar->getSectionByHref($url);
        if ($section) {
            $section->setActive(true);
        }
    }

    public function index()
    {
        $this->section(["section" => "dashboard"]);
    }

    public function viewSection($section, $data = [])
    {
        if (!$this->authenticated()) {
            Application::get()->getLogger()->info("Unauthenticated user tried to access the admin panel");
            $this->redirect(Routes::ADMIN_LOGIN);
            return;
        }
        Application::get()->getLogger()->debug("PanelController->initSidebar()");
        $this->initSidebar();

        $this->title = 'DodoCMS - ' . __('admin.panel.dashboard');

        $alerts =  $this->getAlerts();
        Application::get()->getLogger()->debug("AdminController->getAlerts() : " . (var_export($alerts, true)));

        $section = $this->fetch('panel/index', [
            'alerts' => $alerts,
            'section' => $section,
            'section_data' => $data,
        ]);

        $this->view('panel/layout', [
                'sidebar' => $this->sidebar,
                'content' => $section
            ]
        );
    }
}