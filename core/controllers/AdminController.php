<?php

Autoloader::require('core/classes/controller/DOMController.php');

abstract class AdminController extends DOMController
{

    public function __construct()
    {
        parent::__construct('admin', $this->toRoot('/core/ui/views/admin'), 'core/assets/', 'head', '/panel/document');
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
            if (Session::authenticated())
                return true;
        } catch (Exception $e) {
            Application::get()->getLogger()->error("Error while checking if the user is authenticated: " . $e->getMessage());
        }

        if (Session::hasAdminSession() || Session::hasAdminToken()) {
            $this->addToast(new Toast(__('admin.session.expired.title'), __('admin.session.expired.message'), Toast::TYPE_ERROR));

            Session::removeAdminAccess();
        }
        return false;
    }

    /**
     * Check if the user is authenticated and redirect to the login page if not
     *
     * @return bool
     */
    public function authorization(): bool
    {
        if (!$this->authenticated()) {
            Application::get()->getLogger()->info("Unauthenticated user tried to access the admin panel");
            $this->redirect(NativeRoutes::getRoute(NativeRoutes::ADMIN_LOGIN));
            return false;
        }
        return true;
    }

    public function logout()
    {
        Session::removeAdminAccess();
        $this->redirect(NativeRoutes::getRoute(NativeRoutes::ADMIN_LOGIN));
    }

    public function authentication()
    {
        // Check if the user is already authenticated
        if ($this->authenticated()) {
            $this->redirect(NativeRoutes::getRoute(NativeRoutes::ADMIN_PANEL));
            return;
        }

        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $remember_me = $_POST['remember_me'] == 'on' ?? false;

        // Check if the email and password are not empty
        if ($email === null || $password === null) {
            sleep(3);
            $this->addToast(new Toast(__('admin.login.form.error.empty.title'), __('admin.login.form.error.empty.message'), Toast::TYPE_ERROR));
            $this->redirect(NativeRoutes::getRoute(NativeRoutes::ADMIN_LOGIN));
            return;
        }

        // Check if the user exists
        $users = AdminUserModel::findAll('*', ['email' => $email]);
        if (empty($users)) {
            sleep(3);
            $this->addToast(new Toast(__('admin.login.form.error.invalid.title'), __('admin.login.form.error.invalid.message'), Toast::TYPE_ERROR));
            $this->redirect(NativeRoutes::getRoute(NativeRoutes::ADMIN_LOGIN));
            return;
        }

        /** @var AdminUserModel $user */
        $user = $users[0];
        $expires_in = $remember_me ? 2678400 : Application::get()->getJwtManager()->getExpiresIn();

        // Check the password and create the session
        $userSession = $user->createToken($password, $expires_in);
        if ($userSession === null) {
            $this->addToast(new Toast(__('admin.login.form.error.invalid.title'), __('admin.login.form.error.invalid.message'), Toast::TYPE_ERROR));
            $this->redirect(NativeRoutes::getRoute(NativeRoutes::ADMIN_LOGIN));
            return;
        }

        // Set the user session
        Session::setAdminSession($userSession);

        // Set token session
        Session::setAdminToken($userSession->getToken(), $expires_in);

        // Redirect to the admin panel
        $this->redirect(NativeRoutes::getRoute(NativeRoutes::ADMIN_PANEL));
    }

    public function login()
    {
        if ($this->authenticated()) {
            $this->redirect(NativeRoutes::getRoute(NativeRoutes::ADMIN_PANEL));
            return;
        }

        $this->title = __('admin.login.form.title');
        $this->view('login');
    }

    public function view(string $view, array $data = []): void
    {
        $toasts = $this->getToasts();
        Application::get()->getLogger()->debug("getToasts() = " . var_export($this->getToasts(), true));

        $data['toasts'] = $toasts;
        parent::view($view, $data);
    }
}