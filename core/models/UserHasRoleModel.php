<?php

Autoloader::require("core/classes/database/model/Model.php");

class UserHasRoleModel extends Model
{
    public const TABLE_NAME = "UserHasRole";

    protected string $user_id;
    protected string $role_name;

    public function __construct($user_id = null, $role_name = null)
    {
        parent::__construct(self::TABLE_NAME);
        $this->user_id = $user_id;
        $this->role_name = $role_name;
    }

    public function getUser(): ?AdminUserModel {
        $user = new AdminUserModel();
        $user->id($this->user_id);
        try {
            if ($user->fetch())
                return $user;
        } catch (Exception $e) {
            Application::get()->getLogger()->error('Error fetching user');
            Application::get()->getLogger()->printException($e);
        }
        return null;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getRoleName(): string
    {
        return $this->role_name;
    }

    public function setRoleName(string $role_name): void
    {
        $this->role_name = $role_name;
    }

    public static function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array
    {
        return (new UserHasRoleModel())->getAll($columns, $conditions, $orderBy);
    }
}

Table::registerModel(UserHasRoleModel::TABLE_NAME, UserHasRoleModel::class, Model::MODEL_TYPE_CUSTOM);