<?php

Autoloader::require('core/classes/controller/DOMController.php');
Autoloader::require('core/controllers/AdminController.php');

class PanelController extends AdminController
{

    protected Sidebar $sidebar;

    public function __construct()
    {
        parent::__construct();
    }

    public function initSidebar()
    {
        $tablesSection = [];
        foreach (Table::searchModels(Model::MODEL_TYPE_CUSTOM) as $table => $model) {
            $tablesSection[] = new SidebarSection("tw-me-1 fa-solid fa-table-list", $table, NativeRoutes::getRoute(NativeRoutes::ADMIN_TABLES_TABLE_ENTRIES, ['table' => $table]));
        }

        $modulesSection = [];
        /** @var Module $module */
        foreach (ModulesManager::getModules() as $module) {
            $modulesSection[] = $module->getSidebarSection();
        }

        $adminCenterSection = [
            new SidebarSection("tw-me-1 fa-solid fa-users", __('admin.panel.users.title'), NativeRoutes::getRoute(NativeRoutes::ADMIN_USERS, ['table' => 'Page'])),
//            new SidebarSection("tw-me-1 fa-solid fa-gear", __('admin.panel.configuration.title'), NativeRoutes::getRoute(NativeRoutes::ADMIN_CONFIGURATION, ['table' => 'Page']))
        ];

        $this->sidebar = new Sidebar([
            new SidebarCategory(__("admin.panel.content_manager"), [
                new SidebarSection("tw-me-1 fa-solid fa-images", __('admin.panel.resources.title'), NativeRoutes::getRoute(NativeRoutes::ADMIN_RESOURCES_MANAGER)),
                new SidebarSection("tw-me-1 fa-solid fa-file-lines", __('admin.panel.pages.title'), NativeRoutes::getRoute(NativeRoutes::ADMIN_PAGES_MANAGER, ['table' => 'Page'])),
            ]),
            new SidebarCategory(__("admin.panel.admin_center"), $adminCenterSection),
            new SidebarCategory(__("admin.panel.modules"), $modulesSection),
            new SidebarCategory(__("admin.panel.developer_center"), [
                new SidebarSection("tw-me-1 fa-solid fa-cube", __('admin.panel.block_manager'), NativeRoutes::getRoute(NativeRoutes::ADMIN_BLOCKS_MANAGER)),
                new SidebarSection("tw-me-1 fa-solid fa-database", __('admin.panel.table_management'), NativeRoutes::getRoute(NativeRoutes::ADMIN_TABLES)),
            ]),
            new SidebarCategory(__("admin.panel.models"),
                $tablesSection
            )
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

    public function update() {
        $updater = Application::get()->getUpdater();
        if ($updater->hasUpdate()) {
            $updater->update();
        }
        $this->section(["section" => "dashboard"]);
    }

    public function test() {
        $this->viewSection('test');
    }

    public function viewSection($section, $data = [])
    {
        Application::get()->getLogger()->debug("PanelController->initSidebar()");
        $this->initSidebar();

        $this->title = 'DodoCMS - ' . __('admin.panel.title');

        $alerts = $this->getAlerts();
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