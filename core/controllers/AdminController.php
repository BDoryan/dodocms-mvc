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
        try {
            if(Session::authenticated())
                return true;
        } catch (Exception $e) {
            Application::get()->getLogger()->error("Error while checking if the user is authenticated: " . $e->getMessage());
        }
        if(Session::hasUserSession()) {
            $this->addToast(new Toast(__('admin.session.expired.title'), __('admin.session.expired.message'), Toast::TYPE_ERROR));
            Session::removeUserSession();
        }
        return false;
    }

    public function authentificationMiddleware(): bool
    {
        if (!$this->authenticated()) {
            Application::get()->getLogger()->info("Unauthenticated user tried to access the admin panel");
            $this->redirect(Routes::ADMIN_LOGIN);
            return false;
        }
        return true;
    }

    public function logout() {
        Session::removeUserSession();
        $this->redirect(Routes::ADMIN_LOGIN);
    }

    public function authentication()
    {
        // Check if the user is already authenticated
        if ($this->authenticated()) {
            $this->redirect(Routes::ADMIN_PANEL);
            return;
        }

        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        // Check if the email and password are not empty
        if ($email === null || $password === null) {
            $this->addToast(new Toast(__('admin.login.form.error.empty.title'), __('admin.login.form.error.empty.message'), Toast::TYPE_ERROR));
            $this->redirect(Routes::ADMIN_LOGIN);
            return;
        }

        // Check if the user exists
        $users = UserModel::findAll('*', ['email' => $email]);
        if (empty($users)) {
            $this->addToast(new Toast(__('admin.login.form.error.invalid.title'), __('admin.login.form.error.invalid.message'), Toast::TYPE_ERROR));
            $this->redirect(Routes::ADMIN_LOGIN);
            return;
        }

        $user = $users[0];

        // Check the password and create the session
        $userSession = $user->createToken($password);
        if ($userSession === null) {
            $this->addToast(new Toast(__('admin.login.form.error.invalid.title'), __('admin.login.form.error.invalid.message'), Toast::TYPE_ERROR));
            $this->redirect(Routes::ADMIN_LOGIN);
            return;
        }

        // Set the user session
        Session::setUserSession($userSession);

        // Redirect to the admin panel
        $this->redirect(Routes::ADMIN_PANEL);
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