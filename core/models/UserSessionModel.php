<?php

class UserSessionModel extends Model
{

    public const TABLE_NAME = "UsersHasSessions";

    protected ?int $user_id;
    protected string $token;

    public function __construct(?int $user_id = null, string $token = "")
    {
        parent::__construct(self::TABLE_NAME);

        $this->user_id = $user_id;
        $this->token = $token;
    }

    /**
     * @param int|null $user_id
     */
    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Return the user of the session
     *
     * @return mixed|null
     */
    public function getUser() {
        $user = UserModel::findAll('*', ['user_id' => $this->user_id]);
        if(!empty($user)) {
            return $user[0];
        }
        return null;
    }

    /**
     * Return the token of the session
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    public static function findAll(string $columns = '*', array $conditions = [], $orderBy = ''): ?array
    {
        return (new UserSessionModel())->getAll($columns, $conditions, $orderBy);
    }
}

Table::$models[UserSessionModel::TABLE_NAME] = UserSessionModel::class;