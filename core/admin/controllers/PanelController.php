<?php

Autoloader::require('core/controllers/DOMController.php');
Autoloader::require('core/admin/controllers/AdminController.php');

class PanelController extends AdminController
{

    private Sidebar $sidebar;

    public function __construct()
    {
        parent::__construct();
    }

    public function initSidebar()
    {
        $this->sidebar = new Sidebar([
            new SidebarCategory(__("admin.panel.content_manager"), [
                new SidebarSection("dodocms-me-1 fa-solid fa-images", __('admin.panel.resources.title'), Routes::ADMIN_RESOURCES_MANAGER, [
                    new SidebarSection("dodocms-me-1 fa-solid fa-layer-group", __('admin.panel.dashboard.button.store_file'), Routes::ADMIN_TABLES_NEW),
                ]),
            ]),
            new SidebarCategory(__("admin.panel.admin_center"), [
                new SidebarSection("dodocms-me-1 fa-solid fa-file-lines", __('admin.panel.pages_manager.title'), Routes::getRoute(Routes::ADMIN_TABLES_TABLE_ENTRIES, ['table' => 'Page']), [
                    new SidebarSection("dodocms-me-1 fa-solid fa-layer-group", __('admin.panel.button.store_file'), Routes::ADMIN_PAGES_MANAGER_NEW),
                ]),
                new SidebarSection("dodocms-me-1 fa-solid fa-users", __('admin.panel.users.title'), Routes::getRoute(Routes::ADMIN_USERS_MANAGER, ['table' => 'Page']), [
                    new SidebarSection("dodocms-me-1 fa-solid fa-plus-circle", __('admin.panel.button.store_file'), Routes::ADMIN_USERS_MANAGER_NEW),
                ]),
                new SidebarSection("dodocms-me-1 fa-solid fa-gear", __('admin.panel.configuration.title'), Routes::getRoute(Routes::ADMIN_CONFIGURATION, ['table' => 'Page']), [
                ]),
            ]),
            new SidebarCategory(__("admin.panel.developer_center"), [
                new SidebarSection("dodocms-me-1 fa-solid fa-cube", __('admin.panel.block_manager'), Routes::ADMIN_BLOCKS_MANAGER, [
                    new SidebarSection("dodocms-me-1 fa-solid fa-layer-group", __('admin.panel.block_manager.new'), Routes::ADMIN_TABLES_NEW),
                ]),
                new SidebarSection("dodocms-me-1 fa-solid fa-database", __('admin.panel.table_management'), Routes::ADMIN_TABLES, [
                    new SidebarSection("dodocms-me-1 fa-solid fa-database", __('admin.panel.table_management.new'), Routes::ADMIN_TABLES_NEW),
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
//        if (!$this->authenticated()) {
//            Application::get()->getLogger()->info("Unauthenticated user tried to access the admin panel");
//            $this->redirect(Routes::ADMIN_LOGIN);
//            return;
//        }

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

    public function section(array $params, $data = [])
    {
        $section = $params["section"];
        $this->viewSection($section, $data);
    }
}