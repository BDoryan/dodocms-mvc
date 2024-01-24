<?php

class UserModel extends Model
{

    public const TABLE_NAME = "Users";

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

    public function fetch(): ?UserModel
    {
        $this->tokens = UserSessionModel::findAll("*", ["user_id" => $this->getId()]) ?? [];
        return parent::fetch();
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
     * @throws Exception
     */
    public function setEmail(string $email): void
    {
//        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//            throw new Exception("Invalid email");
//        }
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
        if(empty($password))return;
        $this->password = password_get_info($password)['algo'] ? $password : password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Return password hash
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
        if($jwtManager->verifyToken($token) === null) return false;
        return in_array($token, $this->tokens);
    }

    /**
     * Return the user session if the password is correct
     *
     * @param string $password
     * @return bool
     */
    public function createToken(string $password): ?UserSessionModel
    {
        if ($this->checkPassword($password)) {
            $jwtManager = Application::get()->getJwtManager();

            $expires_in = $jwtManager->getExpiresIn();

            $now = new DateTime();
            $now = $now->add(new DateInterval('PT' . $expires_in . 'S'));

            $token = $jwtManager->createToken(['user_id' => $this->getId()]);

            $userSession = new UserSessionModel($this->getId(), $token, $now->format('Y-m-d H:i:s'));
            $userSession->create();

            $this->tokens[] = $token;
            return $userSession;
        }
        return null;
    }

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
            "size" => "dodocms-w-5/12",
            "field" => Text::create()->name("username")->label(__('admin.panel.users.username'))->value($this->getUsername() ?? "")->required(),
        ];
        $fields["email"] = [
            "size" => "dodocms-w-7/12",
            "field" => Text::create()->name("email")->label(__('admin.panel.users.email'))->value($this->getEmail() ?? "")->required(),
        ];
        $fields["password"] = [
            "size" => "dodocms-w-full",
            "field" => Text::create()->type('password')->name("password")->placeholder("Laisser vide pour maintenir l'ancien mot de passe.")->label(__('admin.panel.users.password'))->value(""),
        ];
        return $fields;
    }

    public static function findAll(string $columns = '*', array $conditions = [], $orderBy = ''): ?array
    {
        return (new UserModel())->getAll($columns, $conditions, $orderBy);
    }
}

Table::$models[UserModel::TABLE_NAME] = UserModel::class;