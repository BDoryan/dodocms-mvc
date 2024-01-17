<?php

Autoloader::require("core/classes/object/CMSObjectHydration.php");

/**
 * For create a model class you need set all attributes of your table in the constructor with a default value
 * 2 : create all getters and setters
 * 3 : create a method getFields() for create a form
 * 4 : create a method findAll() for get all rows of your table
 * 5 : add your model in the array Table::$models
 */
abstract class Model extends CMSObjectHydration
{

    private string $table_name;

    protected ?int $id;
    protected string $createdAt;
    protected string $updatedAt;
    protected ?string $language;
    protected bool $active;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
    }

    /**
     * @throws Exception
     */
    public function fetch(): ?Model
    {
        if (empty($this->id)) throw new Exception("ID is empty");
        $database = Application::get()->getDatabase();
        $result = $database->find($this->table_name, "*", ["id" => $this->id]);

        if (!$result) return null;

        $this->hydrate($result);
        return $this;
    }

    public function createAndFetch(): ?Model
    {
        $this->create();
        return $this->fetch();
    }

    public function create(): bool
    {
        $database = Application::get()->getDatabase();
//        echo "<pre>";
//        var_dump($this->getAttributes());
//        echo "</pre>";
        $database->insert($this->table_name, $this->getAttributes());
        $this->id = $database->lastInsertId();
        return true;
    }

    /**
     * Warning: Its important to know that when we update the model the id can't be modified and the creation date too
     *
     * @return bool
     */
    public function update(): bool
    {
        $this->updatedAt = date("Y-m-d H:i:s");
        $database = Application::get()->getDatabase();

        $ignores = ["id" => "", "createdAt" => ""];
        $attributes = array_diff_key($this->getAttributes(), $ignores);

        $attributes = array_diff_key($attributes, $this->filteredAttributes());

        $database->update($this->table_name, $attributes, ["id" => $this->id]);
        return true;
    }

    public function filteredAttributes(): array
    {
        return ["table_name" => ""];
    }

    public function delete(): bool
    {
        $database = Application::get()->getDatabase();
        $database->delete($this->table_name, ["id" => $this->id]);
        return true;
    }

    public function toArray(): array
    {
        return $this->getAttributes();
    }

    public function getAttributes(): array
    {
        $vars = get_object_vars($this);
        $parentVars = [];
        $childVars = [];

        foreach ($vars as $name => $value) {
            if (get_parent_class($this) !== false && property_exists(get_parent_class($this), $name)) {
                $parentVars[$name] = $value;
            } else {
                $childVars[$name] = $value;
            }
        }

        return array_diff_key(array_merge($parentVars, $childVars), $this->filteredAttributes());
    }

    public function id(?int $id): Model
    {
        $this->setId($id);
        return $this;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function hasId(): bool
    {
        return isset($this->id);
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param string|null $language
     */
    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }

    /**
     * TODO: Il faut savoir qu'il est important de pouvoir mettre en place des vues dédiées à la création du formulaire d'ajout ou de modification
     */

    /**
     * Add default fields
     * - language
     * - active
     *
     * @return array
     */
    public function getFields(): array
    {
        $fields = [];
        if (!empty($this->language)) {
            $fields["language"] = [
                "size" => "dodocms-w-full",
                "field" => Text::create()->name("language")->label("Langue")->value($this->language)
            ];
        }
        $fields['active'] = [
            "size" => "dodocms-w-full dodocms-order-1",
            "field" => Checkbox::create()->name("active")->placeholder("Activation de cet élément")->label("Voulez-vous activer cet élément ?")->value($this->active)
        ];
        return $fields;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table_name;
    }

    public function getAll(string $columns, array $conditions = [], $orderBy = ''): ?array
    {
        $table = Table::getTable($this->table_name);
        if (isset($table)) {
            $entries = $table->findAll($columns, $conditions, $orderBy);
            return array_map(function ($entry) {
                $model = new $this();
                $model->hydrate($entry);
                $model->fetch();

                return $model;
            }, $entries);
        }
        return null;
    }

    public static abstract function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array;


    public static function getModel(Table $table): ?Model
    {
        $model = $table->getModel();
        if (empty($model))
            return null;
        return new $model();
    }

    public static function getModelByTableName(string $table_name): ?Model
    {
        $table = Table::getTable($table_name);
        if (empty($table))
            return null;
        return self::getModel($table);
    }
}