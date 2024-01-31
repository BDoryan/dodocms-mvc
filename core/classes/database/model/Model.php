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
     * Method called when the data of the model is fetched from the database
     * and in this method you can add more data to the model
     *
     * @return UserModel|null
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

    /**
     * Method create the data in the database and fetch the data set in database
     * to this model (instance)
     *
     * @return $this|null
     * @throws Exception
     */
    public function createAndFetch(): ?Model
    {
        $this->create();
        return $this->fetch();
    }

    /**
     * Method create the data in the database (without fetch the data set in database)
     *
     * @return bool
     */
    public function create(): bool
    {
        $database = Application::get()->getDatabase();
        $database->insert($this->table_name, $this->getAttributes());
        $this->id = $database->lastInsertId();
        return true;
    }

    /**
     * Method update the data of this model in the database
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

    /**
     * Method delete the data of this model in the database
     *
     * @return bool
     */
    public function delete(): bool
    {
        $database = Application::get()->getDatabase();
        $database->delete($this->table_name, ["id" => $this->id]);
        return true;
    }

    /**
     * Return the model to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->getAttributes();
    }

    /**
     * Return all attributes of the model (without filtered attributes)
     *
     * @return array
     */
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

    /**
     * Set the id of the model (if the id is null the model will be created in the database)
     * and return the instance of the model
     *
     * @return false|string
     */
    public function id(?int $id): Model
    {
        $this->setId($id);
        return $this;
    }

    /**
     * Set the id of the model (if the id is null the model will be created in the database)
     *
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Return the id of the model
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set activation of the model
     *
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * Return if the model is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Return if the model has an id
     *
     * @return bool
     */
    public function hasId(): bool
    {
        return isset($this->id);
    }

    /**
     * Set the creation date of the model (in instance, if you want update in database use update() method)
     *
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Set the update date of the model (in instance, if you want update in database use update() method)
     *
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Set the language of the model (in instance, if you want update in database use update() method)
     *
     * @param string|null $language
     */
    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }

    /**
     * Return the creation date of the model
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Return the language of the model
     *
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * Return the update date of the model
     *
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * TODO: Il faut savoir qu'il est important de pouvoir mettre en place des vues dédiées à la création du formulaire d'ajout ou de modification
     */

    /**
     * Return if the model has a language attribute (column) in the database
     *
     * @return bool
     */
    public function hasLanguageAttribute() {
        return Table::getTable($this->table_name)->hasAttributeName('language');
    }

    /**
     * Return the fields of the model for create a form (with the template of the field)
     * If you want edit the form of this model you can override this method
     *
     * @return array
     */
    public function getFields(): array
    {
        $fields = [];
        if ($this->hasLanguageAttribute()) {
            $fields["language"] = [
                "size" => "tw-w-4/12 tw-order-1",
                "field" => Text::create()->name("language")->label("Langue")->value($this->language ?? "en")
            ];
        }
        $fields['active'] = [
            "size" => "tw-w-4/12 tw-order-1",
            "field" => Checkbox::create()->name("active")->placeholder("Activation de cet élément")->label("Voulez-vous activer cet élément ?")->value($this->active ?? false)
        ];
        return $fields;
    }

    /**
     * Return the name of the table of the model
     *
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table_name;
    }

    public function getAll(string $columns, array $conditions = [], $orderBy = '', $operators = [], $limit = null): ?array
    {
        $table = Table::getTable($this->table_name);
        if (isset($table)) {
            $entries = $table->findAll($columns, $conditions, $orderBy, $operators, $limit);
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