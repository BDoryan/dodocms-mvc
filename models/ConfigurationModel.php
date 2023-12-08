<?php

Autoloader::require("core/classes/database/model/Model.php");

class ConfigurationModel extends Model
{

    public const TABLE_NAME = "Configuration";

    protected string $configuration_key;
    protected string $value;

    public function __construct(string $configuration_key = "", string $value = "")
    {
        parent::__construct(self::TABLE_NAME);

        $this->configuration_key = $configuration_key;
        $this->value = $value;
    }

    public function getConfigurationKey(): string
    {
        return $this->configuration_key;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setConfigurationKey(string $configuration_key): void
    {
        $this->configuration_key = $configuration_key;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getFields(): array
    {
        $field =  parent::getFields();
        $field[] = [
            "size" => "w-6/12",
            "field" => Text::create()->name("configuration_key")->label("Clé de la configuration")->value($this->getConfigurationKey() ?? "")->required(),
        ];
        $field[] = [
            "size" => "w-6/12",
            "field" => Text::create()->name("value")->label("Valeur de la configuration")->value($this->getValue() ?? "")->required(),
        ];
        return $field;
    }

    public static function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array
    {
        return (new ConfigurationModel())->getAll($columns, $conditions, $orderBy);
    }
}

Table::$models[ConfigurationModel::TABLE_NAME] = ConfigurationModel::class;