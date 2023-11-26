<?php

Autoloader::require("/core/classes/object/CMSObject.php");
Autoloader::require("/core/classes/database/table/Table.php");

class TableAttribute extends CMSObject
{

    public const TYPES = [
        "VARCHAR",
        "INT",
        "DATE",
        "DATETIME",
        "TEXT",
        "BOOLEAN",
        "FLOAT",
        "DOUBLE",
    ];

    protected string $name;
    protected bool $nullable;
    protected bool $auto_increment;
    protected bool $primary_key;
    protected string $type;
    protected ?int $length;
    protected string $default_value;
    protected ?string $association;

    /**
     * @param string $name
     * @param bool $nullable
     * @param bool $auto_increment
     * @param bool $primary_key
     * @param string $type
     * @param ?int $length
     * @param string $default_value
     */
    public function __construct(string $name = "", bool $nullable = false, bool $auto_increment = false, bool $primary_key = false, string $type = "", ?int $length = null, string $default_value = "", $association = "")
    {
        $this->name = $name;
        $this->nullable = $nullable;
        $this->auto_increment = $auto_increment;
        $this->primary_key = $primary_key;
        $this->association = $association;
        $this->type = strtoupper($type);
        $this->length = $length;
        $this->default_value = $default_value;
    }

    public function equals(TableAttribute $attribute): bool
    {
        foreach (get_object_vars($this) as $property => $value) {
            if (!property_exists($attribute, $property) || $attribute->$property !== $value) {
                return false;
            }
        }
        return true;
    }

    public function isDefaultAttribute(): bool
    {
        return Table::isDefaultAttribute($this->name);
    }

    public function isLanguageAttribute(): bool
    {
        return Table::isLanguageAttribute($this->name);
    }

    public function getAssociation(): ?string
    {
        return $this->association;
    }

    public function hasAssociation(): bool
    {
        return !empty($this->association);
    }

    public function setAssociation(string $association): void
    {
        $this->association = $association;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }

    public function setNullable(bool $nullable): void
    {
        $this->nullable = $nullable;
    }

    public function isAutoIncrement(): bool
    {
        return $this->auto_increment;
    }

    public function setAutoIncrement(bool $auto_increment): void
    {
        $this->auto_increment = $auto_increment;
    }

    public function isPrimaryKey(): bool
    {
        return $this->primary_key;
    }

    public function setPrimaryKey(bool $primary_key): void
    {
        $this->primary_key = $primary_key;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = strtoupper($type);
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $length): void
    {
        $this->length = empty($length) ? null : $length;
    }

    public function getDefaultValue(): string
    {
        return $this->default_value;
    }

    public function setDefaultValue(string $default_value): void
    {
        $this->default_value = $default_value;
    }
}