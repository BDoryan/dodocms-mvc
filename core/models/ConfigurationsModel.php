<?php

Autoloader::require("core/classes/database/model/Model.php");

class ConfigurationsModel extends Model
{
    public const TABLE_NAME = "Configurations";

    protected $name;
    protected $value;
    public function __construct($name, $value)
    {

        parent::__construct(self::TABLE_NAME);
        $this->name = $name;
        $this->value = $value;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
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