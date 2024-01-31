<?php

Autoloader::require("core/classes/database/model/Model.php");

class ConfigurationsModel extends Model
{
    public const TABLE_NAME = "Configurations";

    protected string $name;
    protected string $value;
    public function __construct(string $name = '', string $value = '')
    {

        parent::__construct(self::TABLE_NAME);
        $this->name = $name;
        $this->value = $value;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function findAll(string $columns, array  $conditions = [], $orderBy = ''): ?array 
{

        return (new ConfigurationsModel())->getAll($columns, $conditions, $orderBy);

        }

/** Warning: if you want create or edit entries you need to create the form with a override of getFields(); */

}

Table::$models[ConfigurationsModel::TABLE_NAME] = ConfigurationsModel::class;