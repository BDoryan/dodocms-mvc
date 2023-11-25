<?php

Autoloader::require('core/controllers/DOMController.php');

abstract class AdminController extends DOMController
{

    private array $toasts = [];

    public function __construct()
    {
        parent::__construct('admin', $this->toRoot('/core/views'), 'core/assets/', 'head');
    }

    public function addToast(Toast $toast) {
        $this->toasts[] = $toast;
    }

    public function authenticated(): bool
    {
        return true;
    }

    public function authentication()
    {
        /**
         * Authentification ici
         */
        if ($this->authenticated()) {
            $this->redirect(Routes::ADMIN_PANEL);
            return;
        }
        /**
         * Echec de l'authentification
         */
        $this->redirect(Routes::ADMIN_LOGIN);
    }

    public function login()
    {
        if ($this->authenticated()) {
            $this->redirect(Routes::ADMIN_PANEL);
            return;
        }
        $this->title = __('admin.login.form.title');
        $this->view('login');
    }

    public function view($view, $data = []): void
    {
//        $data['toasts'] = $this->toasts;
        parent::view($view, $data);
    }
}