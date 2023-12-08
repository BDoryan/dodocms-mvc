<?php

Autoloader::require("core/classes/database/model/Model.php");

class PermissionModel extends Model
{

    public const TABLE_NAME = "Permission";

    protected string $permission_name;

    public function __construct(string $permission_name = "")
    {
        parent::__construct(self::TABLE_NAME);

        $this->permission_name = $permission_name;
    }

    public function getPermissionName(): string
    {
        return $this->permission_name;
    }

    public function setPermissionName(string $permission_name): void
    {
        $this->permission_name = $permission_name;
    }

    public function getFields(): array
    {
        $field =  parent::getFields();
        $field[] = [
            "size" => "w-6/12",
            "field" => Text::create()->name("permission_name")->label("Clé de la permission")->value($this->getPermissionName() ?? "")->required(),
        ];
        return $field;
    }

    public static function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array
    {
        return (new PermissionModel())->getAll($columns, $conditions, $orderBy);
    }
}

Table::$models[PermissionModel::TABLE_NAME] = PermissionModel::class;