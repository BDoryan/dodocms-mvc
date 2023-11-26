<?php

Autoloader::require('core/controllers/DOMController.php');

abstract class AdminController extends DOMController
{

    public function __construct()
    {
        parent::__construct('admin', $this->toRoot('/core/views'), 'core/assets/', 'head');
    }

    public function addToast(Toast $toast)
    {
        $_SESSION['toasts'][] = $toast;
    }

    public function addAlert(Alert $alert)
    {
        $_SESSION['alerts'][] = $alert;
    }

    /**
     *
     * Return the alerts and clear the session
     *
     * @return array
     */
    public function getAlerts(): array
    {
        $alerts = $_SESSION['alerts'] ?? [];
        $_SESSION['alerts'] = [];
        return $alerts;
    }

    /**
     *
     * Return the toasts and clear the session
     *
     * @return array
     */
    public function getToasts(): array
    {
        $toasts = $_SESSION['toasts'] ?? [];
        $_SESSION['toasts'] = [];
        return $toasts;
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
        $toasts = $this->getToasts();
        Application::get()->getLogger()->debug("getToasts() = " . var_export($this->getToasts(), true));

        $data['toasts'] = $toasts;
        parent::view($view, $data);
    }
}