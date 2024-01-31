<?php

class Setup
{

    /**
     * All steps for installation
     * - Connection to mysql and create database and insert all tables
     * - Create admin user
     */

    private static function generateSalt(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Return all alerts of the session and delete them
     *
     * @return array|mixed
     */
    private static function getAlerts()
    {
        $alerts = Session::get('alerts') ?? [];
        Session::set('alerts', []);
        return $alerts;
    }

    /**
     * Add alert to the session for show it after page reload
     *
     * @param Alert $alert
     * @return void
     */
    private static function addAlert(Alert $alert)
    {
        $alerts = self::getAlerts();
        $alerts[] = $alert;
        Session::set('alerts', $alerts);
    }

    /**
     * Return true if the form is submitted
     *
     * @return bool
     */
    private static function isPost(): bool
    {
        return !empty($_POST);
    }

    /**
     * Return the current step
     *
     * @return int
     */
    private static function getStep(): int
    {
        return !empty($_POST['step']) ? intval($_POST['step']) : (!empty($_GET['step']) ? intval($_GET['step']) : 1);
    }

    /**
     * Setup the database with the sql files in setup/sql
     *
     * @param PDO $connection
     * @param string $database
     * @return void
     */
    private static function setupDatabase(PDO $connection, string $database): void
    {
        $sql = "
                CREATE DATABASE IF NOT EXISTS `$database`;
                USE `$database`;
            ";

        $files = glob(Application::get()->toRoot("/setup/sql/*.sql"));
        foreach ($files as $file) {
            $sql .= file_get_contents($file);
        }

        try {
            Database::exec($connection, $sql);
        } catch (Exception $e) {
            Application::get()->getLogger()->error("Error while executing sql file $file");
            Application::get()->getLogger()->printException($e);
            self::addAlert(new Alert(__("setup.database.error"), $e->getMessage(), Toast::TYPE_ERROR));
            return;
        }

        Database::stopConnection($connection);
        Application::get()->redirect('?step=2');
    }

    /**
     * Return the view of the step with the step number
     * and redirect to the next step if the form is submitted with success
     * If the step is not found, throw an exception
     *
     * @param int|null $step
     * @return array|null
     * @throws Exception
     */
    private static function getStepView(?int $step = null): ?array
    {
        $configuration = Application::get()->getConfigurationInstance();

        $config = Application::get()->getConfiguration();
        $hostname = !empty($_POST['hostname']) ? $_POST['hostname'] : $config['mysql']['hostname'];
        $username = !empty($_POST['username']) ? $_POST['username'] : $config['mysql']['username'];
        $database = !empty($_POST['database']) ? $_POST['database'] : $config['mysql']['database'];
        $password = !empty($_POST['password']) ? $_POST['password'] : $config['mysql']['password'];

        if (empty($hostname) || empty($username) || empty($database) || $step == 1) {
            if (self::isPost()) {
                try {
                    $connection = Database::getConnection($hostname, $username, $password);

                    $configuration->set('mysql', [
                        'hostname' => $hostname,
                        'username' => $username,
                        'database' => $database,
                        'password' => $password
                    ]);
                    $configuration->save();

                    self::setupDatabase($connection, $database);
                } catch (Exception $e) {
                    self::addAlert(new Alert(__("setup.database.connection_failed"), __("setup.database.please_verify_credentials"), Toast::TYPE_ERROR));
                }
            }
            return [
                'title' => __('setup.database.title'),
                'step' => 1,
                'can_next' => true,
                'can_previous' => true,
                'content' => fetch(Application::get()->toRoot('/setup/views/steps/database'), [
                    'hostname' => $hostname,
                    'username' => $username,
                    'database' => $database,
                    'password' => $password
                ])
            ];
        }

        $username = !empty($_POST['username']) ? $_POST['username'] : '';
        $password = !empty($_POST['password']) ? $_POST['password'] : '';
        $email = !empty($_POST['email']) ? $_POST['email'] : '';

        if ($step == 2) {
            $array = [
                'title' => __('setup.user.root.title'),
                'step' => 2,
                'can_next' => true,
                'can_previous' => true,
                'content' => fetch(Application::get()->toRoot('/setup/views/steps/admin'), [
                    'username' => $username,
                    'password' => $password,
                    'email' => $email
                ])
            ];
            try {
                Application::get()->connectDatabase();
                if(count(UserModel::findAll()) > 0) {
                    Application::get()->redirect('?step=3');
                    exit;
                }

                if (self::isPost()) {
                    if (empty($username) || empty($password) || empty($email)) {
                        self::addAlert(new Alert(__("setup.user.root.error"), __("setup.user.root.please_fill_all_fields"), Toast::TYPE_ERROR));
                    } else {

                        if (!UserModel::emailAvailable($email)) {
                            self::addAlert(new Alert(__("setup.user.root.error"), __("setup.user.root.email_already_used"), Toast::TYPE_ERROR));
                            return $array;
                        }

                        if (!UserModel::checkValidationOfPassword($password)) {
                            self::addAlert(new Alert(__("setup.user.root.error"), __("setup.user.root.password_not_valid"), Toast::TYPE_ERROR));
                            return $array;
                        }

                        $user = new UserModel();
                        $user->setUsername($username);
                        $user->setPassword($password);
                        $user->setEmail($email);
                        $user->setActive(true);
                        if ($user->create()) {
                            Application::get()->redirect('?step=3');
                            exit;
                        }
                        self::addAlert(new Alert(__("setup.user.root.error"), __("setup.user.root.error_while_create_user"), Toast::TYPE_ERROR));
                    }
                }
            } catch (Exception $e) {
                Application::get()->getLogger()->error("Error while create the user");
                Application::get()->getLogger()->printException($e);
                self::addAlert(new Alert(__("setup.database.error"), $e->getMessage(), Toast::TYPE_ERROR));
            }
            return $array;
        }

        if ($step == 3) {
            $array = [
                'title' => __('setup.finish.title'),
                'step' => 3,
                'can_next' => true,
                'can_previous' => false,
                'content' => fetch(Application::get()->toRoot('/setup/views/steps/finish'))
            ];
            if (self::isPost()) {
                Application::get()->redirect('/admin');
            }
            return $array;
        }
        throw new Exception('Step not found !');
    }

    /**
     * Run the setup
     * @throws Exception
     */
    public static function run(): void
    {
        $step = self::getStepView(self::getStep());

        view(Application::get()->toRoot('/core/ui/views/admin/panel/document'), [
            'head' => fetch(Application::get()->toRoot('/setup/views/head'), [
                'title' => $step['title']
            ]),
            'content' => fetch(Application::get()->toRoot('/setup/views/layout'), [
                'title' => $step['title'],
                'alerts' => self::getAlerts(),
                'content' => $step['content'],
                'step' => $step['step'] ?? 2,
                'can_next' => $step['can_next'] ?? false,
                'total_steps' => 3,
                'can_previous' => $step['can_previous'] ?? false
            ])
        ]);
    }
}