<?php

Autoloader::require("core/classes/collection/attribute/TableAttribute.php");
Autoloader::require("core/exceptions/SQLException.php");
Autoloader::require("core/classes/utils/Tools.php");
Autoloader::require("core/classes/object/CMSObject.php");

class Table extends CMSObject
{

    private static array $models = [];

    /**
     * Register a model in the system
     *
     * @param string $table
     * @param $model
     * @param string|null $type
     * @return void
     */
    public static function registerModel(string $table, $model, ?string $type = null): void
    {
        if ($type == null)
            $type = Model::MODEL_TYPE_CMS;
        self::$models[$type][$table] = $model;
    }

    /**
     * Return the type of the model (custom, model or cms)
     *
     * @param $table
     * @return string|null
     */
    public static function getTypeOfModel($table): ?string {
        foreach(self::$models as $type => $models)
            if(isset($models[$table]))
                return $type;
        return null;
    }

    /**
     * Return the model associated to the table
     *
     * @param string $table the name of the table
     * @param string|null $type if is null search in all models else search by the type
     *
     * @return Model|null the model associated to the table or null if not found
     */
    public static function searchModel(string $table, ?string $type = null): ?Model
    {
        if ($type == null) {
            foreach (self::$models as $type => $models)
                if (isset($models[$table]))
                    return new $models[$table];
        } else {
            if (isset(self::$models[$type][$table]))
                return new self::$models[$type][$table];
        }
        return null;
    }

    /**
     * Return the model associated to the table
     *
     * @param string|null $type if is null search in all models else search by the type
     *
     * @return array the model associated to the table or null if not found
     */
    public static function searchModels(?string $type = null): array
    {
        if ($type == null) {
            return self::getModels();
        }
        return self::$models[$type] ?? [];
    }

    protected string $name;
    protected array $attributes;

    public function __construct(string $name = "", array $attributes = [])
    {
        $this->name = $name;
        $this->attributes = $attributes;
    }

    public function hydrate(array $data): void
    {
        $this->name = $data['name'];
        $this->attributes = [];
        foreach ($data['attributes'] as $attribute) {
            $table_attribute = new TableAttribute();
            $table_attribute->hydrate($attribute);
            $table_attribute->check();

            $this->attributes[] = $table_attribute;
        }
    }

    public function getModel(): ?Model
    {
        $model = self::searchModel($this->getName());
        if (!empty($model))
            return new $model;
        return null;
    }

    public function destroy(): void
    {
        $sql = "DROP TABLE " . $this->getName() . ";";
        Application::get()->getDatabase()->execute($sql);

        $migration = Migration::create(Application::get()->toRoot("/migrations/".$this->getName()), $sql);
        $migration->save();
    }

    private function getConstraintNameByColumn($column_name)
    {
        $sql = "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = '" . $this->getName() . "' AND COLUMN_NAME = '$column_name' AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1";
        $result = Application::get()->getDatabase()->fetch($sql);
        return $result['CONSTRAINT_NAME'];
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
                if (!empty($attribute->getAssociation())) {
                    $sql .= "ALTER TABLE " . $this->getName() . " DROP FOREIGN KEY " . ($this->getConstraintNameByColumn($attribute->getName())) . "\n";
                }
                $sql .= "ALTER TABLE " . $this->getName() . " DROP COLUMN " . $attribute->getName() . ";\n";
            }
        }

        foreach ($collection->attributes as $attribute) {
            if (Table::isDefaultAttribute($attribute->getName())) continue;

            $length = !empty($attribute->getLength()) ? "(" . $attribute->getLength() . ")" : '';

            if (!$this->hasAttribute($attribute)) {
                $sql .= "ALTER TABLE " . $this->getName() . " ADD COLUMN " . $attribute->getName() . " " . $attribute->getType() . " $length " . (($attribute->isNullable() || $attribute->hasAssociation())? "" : "NOT NULL") . " " . ($attribute->isAutoIncrement() ? "AUTO_INCREMENT" : "") . " " . (!empty($attribute->getDefaultValue()) ? "DEFAULT " . ($attribute->getDefaultValue() === "CURRENT_TIMESTAMP" ? $attribute->getDefaultValue() : "'" . $attribute->getDefaultValue() . "'") : "") . ";\n";

                if ($attribute->hasAssociation()) {
                    $sql .= "ALTER TABLE " . $this->getName() . " ADD CONSTRAINT " . 'fk_' . $attribute->getAssociation() . " FOREIGN KEY (" . $attribute->getName() . ") REFERENCES " . $attribute->getAssociation() . "(id);\n";
                }
            } else {
                $existingAttribute = $this->getAttribute($attribute);

                if (
                    $existingAttribute->getDefaultValue() != $attribute->getDefaultValue() ||
                    $existingAttribute->isNullable() != $attribute->isNullable() ||
                    $existingAttribute->getType() != $attribute->getType() ||
                    $existingAttribute->getLength() != $attribute->getLength()
                ) {

                    $sql .=
                        "ALTER TABLE " . $this->getName() . " MODIFY COLUMN " . $attribute->getName() . " " . $attribute->getType() . " $length " . ($attribute->isNullable() ? "NULL" : "NOT NULL") . " " . ($attribute->isAutoIncrement() ? "AUTO_INCREMENT" : "") . " " . (!empty($attribute->getDefaultValue()) ? "DEFAULT " . ($attribute->getDefaultValue() === "CURRENT_TIMESTAMP" ? $attribute->getDefaultValue() : "'" . $attribute->getDefaultValue() . "'") : "") . ";\n";
                }

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
                        $sql .= "ALTER TABLE " . $this->getName() . " ADD CONSTRAINT " . 'fk_' . $attribute->getAssociation() . " FOREIGN KEY (" . $attribute->getName() . ") REFERENCES " . $attribute->getAssociation() . "(id);\n";
                    }
                }
            }
        }

        if (empty($sql))
            return "";

        try {
            $requests = explode("\n", $sql);
            foreach ($requests as $request) {
                if (!empty($request)) {
                    Application::get()->getDatabase()->execute($request);
                }
            }
            $this->fetch();

            $migration = Migration::create(Application::get()->toRoot("/migrations/".$this->getName()), $sql);
            $migration->save();

            return implode("<br>", $requests);
        } catch (Exception $e) {
            throw new SQLException($e->getMessage(), $e->getCode(), $sql);
        }
    }

    public function findAll($columns = '*', $conditions = [], $orderBy = null, $operators = [], $limit = null): array
    {
        return Application::get()->getDatabase()->findAll($this->getName(), $columns, $conditions, $orderBy, $operators, $limit);
    }

    /**
     * @throws Exception
     */
    public function fetch(): void
    {
        $this->hydrate(self::getTableData($this->getName()));
    }

    public function toJson()
    {
        return json_encode($this->toArray());
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
            $attributes = array_map(function (TableAttribute $attribute) {
                return $attribute->getName();
            }, $this->attributes);


            $requests = explode("\n", $sql);
            Application::get()->getDatabase()->execute($sql);

            new ModelGenerator($this->name, $attributes);

            $migration = Migration::create(Application::get()->toRoot("/migrations/".$this->getName()), $sql);
            $migration->save();

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
            new TableAttribute("active", false, false, false, "TINYINT", 1, 0),
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
    public static function getTableData($table_name): ?array
    {
        $collection = self::getTable($table_name);
        return $collection->toArray();
    }

    public static function getTable($table_name): ?Table
    {
        $database = Application::get()->getDatabase();
        if ($database->existTable($table_name) === false) return null;
        $describe = $database->describe($table_name);
        if (empty($describe)) return null;

        $collection = new Table($table_name, []);
        foreach ($describe as $attribute) {
            $name = $attribute['Field'];
            $nullable = $attribute['Null'] === "YES";
            $auto_increment = $attribute['Extra'] === "auto_increment";
            $primary_key = $attribute['Key'] === "PRI";
            $column_datas = Tools::getColumnData($attribute['Type']);
            $type = $column_datas['type'];
            $length = $column_datas['length'] ?? null;
            $association = "";


            $hasAssociation = $database->fetch("SELECT REFERENCED_TABLE_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = ? AND COLUMN_NAME = ? AND REFERENCED_TABLE_NAME IS NOT NULL", [$table_name, $name]);
            if ($hasAssociation) {
                $association = $hasAssociation['REFERENCED_TABLE_NAME'];
            }

            $default_value = "";

            if (!empty($attribute['Default'])) {
                $default_value = $attribute['Default'];
            }

            $table_attribute = new TableAttribute($name, $nullable, $auto_increment, $primary_key, $type, $length, $default_value, $association);
            $collection->addAttribute($table_attribute);
        }
        return $collection;
    }

    public static function listTablesName(): array
    {
        $database = Application::get()->getDatabase();
        return $database->showTables();
    }

    public static function getTables(): array
    {
        $database = Application::get()->getDatabase();
        $tables_ = $database->showTables();
        $tables = [];
        foreach ($tables_ as $table) {
            $tables[] = self::getTable($table);
        }
        return $tables;
    }

    public static function getModels(): array
    {
//        // get all array stored in values for create one array
//        $models = [];
//        foreach (self::$models as $type => $models_)
//            foreach ($models_ as $table => $model)
//                $models[$table] = $model;
        return self::$models;
    }
}