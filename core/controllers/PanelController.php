<?php

Autoloader::require('core/controllers/DOMController.php');

class PanelController extends AdminController
{

    private Sidebar $sidebar;

    public function __construct()
    {
        parent::__construct('admin', $this->toRoot('/core/views'), 'core/assets/', 'head');
    }

    public function initLayout()
    {
        $this->setLayout('/admin/panel/layout');
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

    public function section(array $params)
    {
        if (!$this->authenticated()) {
            $this->redirect(Routes::ADMIN_LOGIN);
            return;
        }
        $this->initLayout();
        $this->initSidebar();

        $section = $params["section"];

        $this->title = 'DodoCMS - ' . __('admin.panel.dashboard');
        $this->view('panel/index', ['sidebar' => $this->sidebar, 'section' => $section]);
    }
}