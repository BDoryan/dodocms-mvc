<?php

class UserModel extends Model
{

    public const TABLE_NAME = "Users";

    private string $username;
    private string $email;
    private string $password;

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
        $regex = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/";
        if (!preg_match($regex, $email)) {
            throw new Exception("Invalid email");
        }
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
            "field" => Text::create()->name("email")->label(__('admin.panel.users.password'))->value("")->required(),
        ];
        return $fields;
    }

    public static function findAll(string $columns = '*', array $conditions = [], $orderBy = ''): ?array
    {
        return (new UserModel())->getAll($columns, $conditions, $orderBy);
    }
}

Table::$models[UserModel::TABLE_NAME] = UserModel::class;