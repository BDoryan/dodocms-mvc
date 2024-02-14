<?php

class AdminUserModel extends Model
{

    public const TABLE_NAME = "AdminUsers";

    protected string $username;
    protected string $email;
    protected string $password;
    private array $tokens;

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string|null $language
     */
    public function __construct(string $username = "", string $email = "", string $password = "", string $language = null)
    {
        parent::__construct(self::TABLE_NAME);

        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->language = $language;
    }

    /**
     * Method called when the data of the model is fetched from the database
     * and in this method you can add more data to the model
     *
     * @return AdminUserModel|null
     * @throws Exception
     */
    public function fetch(): ?AdminUserModel
    {
        $this->tokens = AdminUserSessionModel::findAll("*", ["user_id" => $this->getId(), "expire_at" => date('Y-m-d H:i:s')]) ?? [];
        return parent::fetch();
    }

    public function create(): bool
    {
        // check if email are not already used
        if (!AdminUserModel::emailAvailable($this->getEmail())) {
            throw new Exception("Email already used");
        }

        // check if password is valid
        if (!AdminUserModel::checkValidationOfPassword($this->getPassword())) {
            throw new Exception("Password is not valid");
        }

        return parent::create();
    }

    /**
     * @return array
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * Return the email of the user
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the email of the user
     *
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Return the username of the user
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Set password with hash (and if is already hashed, don't hash it again)
     *
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        if (empty($password)) return;
        $this->password = password_get_info($password)['algo'] ? $password : password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Return password hashed
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Return if the token is valid (not expired and in the database)
     *
     * @throws Exception
     */
    public function checkToken(string $token): bool
    {
        $jwtManager = Application::get()->getJwtManager();
        if ($jwtManager->verifyToken($token) === null) return false;
        return in_array($token, $this->tokens);
    }

    /**
     * Return the user session if the password is correct
     *
     * @param string $password
     * @return AdminUserSessionModel|null
     * @throws Exception
     */
    public function createToken(string $password, ?int $expires_in = null): ?AdminUserSessionModel
    {
        if ($this->checkPassword($password)) {
            $jwtManager = Application::get()->getJwtManager();

            $expires_in = $expires_in == null ? $jwtManager->getExpiresIn() : $expires_in;

            $now = new DateTime();
            $now = $now->add(new DateInterval('PT' . $expires_in . 'S'));

            $token = $jwtManager->createToken(['user_id' => $this->getId()], $expires_in);

            $userSession = new AdminUserSessionModel($this->getId(), $token, $now->format('Y-m-d H:i:s'));
            $userSession->create();

            $this->tokens[] = $token;
            return $userSession;
        }
        return null;
    }

    /**
     * Verify if the password is correct with the hash
     *
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->getPassword());
    }

    /**
     * Return all fields of the model
     *
     * @return array
     */
    public function getFields(): array
    {
        $fields = parent::getFields();
        $fields["username"] = [
            "size" => "tw-w-5/12",
            "field" => Text::create()
                ->name("username")
                ->label(__('admin.panel.users.username'))
                ->value($this->getUsername() ?? "")
                ->required(),
        ];
        $fields["email"] = [
            "size" => "tw-w-7/12",
            "field" => Text::create()
                ->type('email')
                ->name("email")
                ->label(__('admin.panel.users.email'))
                ->value($this->getEmail() ?? "")
                ->required(),
        ];
        $fields["password"] = [
            "size" => "tw-w-full",
            "field" => Text::create()
                ->type('password')
                ->name("password")
                ->placeholder(__('admin.panel.users.password.placeholder'))
                ->label(__('admin.panel.users.password'))
                ->value(""),
        ];
        return $fields;
    }

    public static function checkValidationOfPassword(string $password): bool
    {
        return Validator::validatePassword($password);
    }

    public static function emailAvailable(string $email): bool
    {
        $users = AdminUserModel::findAll("*", ["email" => $email]);
        return empty($users);
    }

    public static function findAll(string $columns = '*', array $conditions = [], $orderBy = ''): ?array
    {
        return (new AdminUserModel())->getAll($columns, $conditions, $orderBy);
    }
}

Table::registerModel(AdminUserModel::TABLE_NAME, AdminUserModel::class);