<?php

Autoloader::require("core/classes/collection/attribute/TableAttribute.php");
Autoloader::require("core/exceptions/sql/SQLException.php");
Autoloader::require("core/classes/utils/Tools.php");
Autoloader::require("core/classes/object/CMSObject.php");

class Table extends CMSObject
{

    public static array $models = [];

    protected string $name;
    protected array $attributes;

    public function __construct(string $name = "", array $attributes = [])
    {
        $this->name = $name;
        $this->attributes = $attributes;
    }

    public function hydrate(array $datas): void
    {
        $this->name = $datas['name'];
        $this->attributes = [];
        foreach ($datas['attributes'] as $attribute) {
            $collection_attribute = new TableAttribute();
            $collection_attribute->hydrate($attribute);
            $this->attributes[] = $collection_attribute;
        }
    }

    public function getModel(): ?Model
    {
        if (isset(self::$models[$this->getName()]))
            return new self::$models[$this->getName()];
        return null;
    }

//    public function delete(int $id): bool
//    {
//        $database = Application::getDatabase();
//        $element = $database->fetch($this->getName(), ["id" => $id]);
//        if (!$element) return false;
//        return $database->delete($this->getName(), ["id" => $id]);
//    }

    public function destroy(): void
    {
        $sql = "DROP TABLE " . $this->getName() . ";";
        Application::getDatabase()->execute($sql);
    }

    public function update(Table $collection): string
    {
        $sql = "";
        if ($collection->getName() != $this->getName()) {
            $sql .= "RENAME TABLE " . $this->getName() . " TO " . $collection->getName() . ";\n";
            $this->setName($collection->getName());
        }

        /** @var TableAttribute $attribute */
        foreach ($this->attributes as $attribute) {
            if (!$collection->hasAttribute($attribute)) {
                if ($attribute->isPrimaryKey()) {
                    $sql .= "ALTER TABLE " . $this->getName() . " DROP PRIMARY KEY;\n";
                }
                $sql .= "ALTER TABLE " . $this->getName() . " DROP COLUMN " . $attribute->getName() . ";\n";
            }
        }

        foreach ($collection->attributes as $attribute) {
            if (!$this->hasAttribute($attribute)) {
                $sql .= "ALTER TABLE " . $this->getName() . " ADD COLUMN " . $attribute->getName() . " " . $attribute->getType() . "(" . $attribute->getLength() . ") " . ($attribute->isNullable() ? "NULL" : "NOT NULL") . " " . ($attribute->isAutoIncrement() ? "AUTO_INCREMENT" : "") . " " . (!empty($attribute->getDefaultValue()) ? "DEFAULT " . ($attribute->getDefaultValue() === "CURRENT_TIMESTAMP" ? $attribute->getDefaultValue() : "'" . $attribute->getDefaultValue() . "'") : "") . ";\n";

                if ($attribute->hasAssociation()) {
                    $sql .= "ALTER TABLE " . $this->getName() . " ADD CONSTRAINT " . $attribute->getAssociation() . " FOREIGN KEY (" . $attribute->getName() . ") REFERENCES " . $attribute->getAssociation() . "(id);\n";
                }
            } else {
                $existingAttribute = $this->getAttribute($attribute);
                if ($attribute->isPrimaryKey() != $existingAttribute->isPrimaryKey() && $attribute->isPrimaryKey()) {
                    $sql .= "ALTER TABLE " . $this->getName() . " ADD PRIMARY KEY (" . $attribute->getName() . ");\n";
                }

                if ($attribute->isPrimaryKey() != $existingAttribute->isPrimaryKey() && !$attribute->isPrimaryKey()) {
                    $sql .= "ALTER TABLE " . $this->getName() . " DROP PRIMARY KEY;\n";
                }

                if (!empty($attribute->getAssociation())) {
                    if (empty($existingAttribute->getAssociation()) || $existingAttribute->getAssociation() !== $attribute->getAssociation()) {
                        if (!empty($existingAttribute->getAssociation())) {
                            $sql .= "ALTER TABLE " . $this->getName() . " DROP FOREIGN KEY " . $existingAttribute->getAssociation() . ";\n";
                        }
                        $sql .= "ALTER TABLE " . $this->getName() . " ADD CONSTRAINT " . $attribute->getAssociation() . " FOREIGN KEY (" . $attribute->getName() . ") REFERENCES " . $attribute->getAssociation() . "(id);\n";
                    }
                }
            }
        }

        if (empty($sql)) {
            return "";
        }

        try {
            $requests = explode("\n", $sql);
            foreach ($requests as $request) {
                if (!empty($request)) {
                    Application::getDatabase()->execute($request);
                }
            }
            $this->fetch();
            return implode("<br>", $requests);
        } catch (Exception $e) {
            throw new SQLException($e->getMessage(), $e->getCode(), $sql);
        }
    }

    public function findAll($columns = '*', $conditions = [], $orderBy = null, $limit = null): array
    {
        return Application::getDatabase()->findAll($this->getName(), $columns, $conditions, $orderBy, $limit);
    }

    public function fetch(): void
    {
        $this->hydrate(self::getCollectionData($this->getName()));
    }

    /**
     * @throws Exception
     */
    public function create(): string
    {
        $sql = "CREATE TABLE $this->name (\n";
        $primaryKeys = "";
        $foreignKeys = [];

        /** @var TableAttribute $attribute */
        foreach ($this->attributes as $attribute) {
            $name = $attribute->getName();
            $type = $attribute->getType();
            $nullable = ($attribute->isNullable()) ? 'NULL' : 'NOT NULL';
            $default = !empty($attribute->getDefaultValue()) ? "DEFAULT " . ($attribute->getDefaultValue() === "CURRENT_TIMESTAMP" ? $attribute->getDefaultValue() : "'" . $attribute->getDefaultValue() . "'") : '';
            $autoIncrement = ($attribute->isAutoIncrement()) ? 'AUTO_INCREMENT' : '';
            $length = !empty($attribute->getLength()) ? "(" . $attribute->getLength() . ")" : '';

            if ($attribute->isPrimaryKey()) {
                $primaryKeys .= ($primaryKeys == "") ? $name : ", " . $name;
            }

            if (!empty($attribute->getAssociation())) {
                $foreignKeys[] = "   FOREIGN KEY ($name) REFERENCES " . $attribute->getAssociation() . "(id)";
            }

            $sql .= "   $name $type$length $nullable $default $autoIncrement,\n";
        }

        if (!empty($primaryKeys)) {
            $sql .= "   PRIMARY KEY ($primaryKeys),\n";
        }

        if (!empty($foreignKeys)) {
            $sql .= implode(",\n", $foreignKeys);
        }

        $sql = rtrim($sql, ",\n") . "\n);";

        try {
            $requests = explode("\n", $sql);
            Application::getDatabase()->execute($sql);
            return implode("<br>", $requests);
        } catch (Exception $e) {
            throw new SQLException($e->getMessage(), $e->getCode(), $sql);
        }
    }

    public static function getDefaultAttributes(): array
    {
        return [
            new TableAttribute("id", false, true, true, "INT", 11, ""),
            new TableAttribute("createdAt", false, false, false, "DATETIME", 19, "CURRENT_TIMESTAMP"),
            new TableAttribute("updatedAt", false, false, false, "DATETIME", 19, "CURRENT_TIMESTAMP"),
        ];
    }

    public function hasAllDefaultAttributes(): bool
    {
        $defaults = [];
        foreach ($this->attributes as $attribute)
            if ($attribute->getName() === "id" || $attribute->getName() === "createdAt" || $attribute->getName() === "updatedAt")
                $defaults[] = $attribute->getName();

        return count(self::getDefaultAttributes()) == count($defaults);
    }

    public function hasAttribute(TableAttribute $attribute): bool
    {
        return $this->hasAttributeName($attribute->getName());
    }

    public function getAttribute(TableAttribute $attribute): ?TableAttribute
    {
        return $this->getAttributeByName($attribute->getName());
    }

    public function getAttributeByName(string $attribute_name): ?TableAttribute
    {
        foreach ($this->attributes as $attribute)
            if ($attribute->getName() === $attribute_name)
                return $attribute;
        return null;
    }

    public function hasAttributeName(string $attribute_name): bool
    {
        foreach ($this->attributes as $attribute)
            if ($attribute->getName() === $attribute_name)
                return true;
        return false;
    }

    public static function isLanguageAttribute(string $attribute_name): bool
    {
        return $attribute_name === "language";
    }

    public static function isDefaultAttribute(string $attribute_name): bool
    {
        foreach (self::getDefaultAttributes() as $attribute)
            if ($attribute->getName() === $attribute_name)
                return true;
        return false;
    }

    public function hasLanguageAttribute(): bool
    {
        foreach ($this->attributes as $attribute)
            if ($attribute->getName() === "language")
                return true;
        return false;
    }

    public function addAttribute(TableAttribute $attribute): void
    {
        $this->attributes[] = $attribute;
    }

    public function removeAttribute(TableAttribute $attribute): void
    {
        foreach ($this->attributes as $index => $attribute_) {
            if ($attribute === $attribute_) {
                unset($this->attributes[$index]);
            }
        }
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @throws Exception
     */
    public static function getCollectionData($collection_name): ?array
    {
        $collection = self::getCollection($collection_name);
        return $collection->toArray();
    }

    public static function getCollection($collection_name): ?Table
    {
        $database = Application::getDatabase();
        if ($database->existTable($collection_name) === false) return null;
        $describe = $database->describe($collection_name);
        if (empty($describe)) return null;

        $collection = new Table($collection_name, []);
        foreach ($describe as $attribute) {
            $name = $attribute['Field'];
            $nullable = $attribute['Null'] === "YES";
            $auto_increment = $attribute['Extra'] === "auto_increment";
            $primary_key = $attribute['Key'] === "PRI";
            $column_datas = Tools::getColumnData($attribute['Type']);
            $type = $column_datas['type'];
            $length = $column_datas['length'] ?? null;
            $association = "";

            $hasAssociation = $database->fetch("SELECT REFERENCED_TABLE_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = ? AND COLUMN_NAME = ? AND REFERENCED_TABLE_NAME IS NOT NULL", [$collection_name, $name]);
            if ($hasAssociation) {
                $association = $hasAssociation['REFERENCED_TABLE_NAME'];
            }

            $default_value = "";

            if (!empty($attribute['Default'])) {
                $default_value = $attribute['Default'];
            }

            $collection->addAttribute(new TableAttribute($name, $nullable, $auto_increment, $primary_key, $type, $length, $default_value, $association));
        }
        return $collection;
    }

    public static function getCollections(): array
    {
        $database = Application::getDatabase();
        $tables = $database->showTables();
        $collections = [];
        foreach ($tables as $table) {
            $collections[] = self::getCollection($table);
        }
        return $collections;
    }
}