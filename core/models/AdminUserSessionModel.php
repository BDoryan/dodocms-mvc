<?php

class AdminUserSessionModel extends Model
{

    public const TABLE_NAME = "AdminUsersHasSessions";

    protected ?int $user_id;
    protected string $token;
    protected string $expire_at;

    public function __construct(?int $user_id = null, string $token = "", $expire_at = 'current_timestamp')
    {
        parent::__construct(self::TABLE_NAME);

        $this->user_id = $user_id;
        $this->token = $token;
        $this->expire_at = $expire_at;
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
     * @param string $expire_at
     */
    public function setExpireAt(string $expire_at): void
    {
        $this->expire_at = $expire_at;
    }

    /**
     * @return string
     */
    public function getExpireAt(): string
    {
        return $this->expire_at;
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
    public function getUser()
    {
        $user = AdminUserModel::findAll('*', ['id' => $this->user_id]);
        if (!empty($user))
            return $user[0];
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

    public static function findAll(string $columns = '*', array $conditions = [], $orderBy = '', $operators = []): ?array
    {
        return (new AdminUserSessionModel())->getAll($columns, $conditions, $orderBy, $operators);
    }
}

Table::registerModel(AdminUserSessionModel::TABLE_NAME, AdminUserSessionModel::class);