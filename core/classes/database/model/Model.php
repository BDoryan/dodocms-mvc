<?php

Autoloader::require("core/classes/object/CMSObjectHydration.php");

abstract class Model extends CMSObjectHydration
{

    private string $table_name;

    protected ?int $id;
    protected string $createdAt;
    protected string $updatedAt;
    protected ?string $language;

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

        $attributes = array_diff_key($this->getAttributes(), ["id" => "", "createdAt" => ""]);
        $database->update($this->table_name, $attributes, ["id" => $this->id]);
        return true;
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

        return array_merge(array_diff_key($parentVars, ["table_name" => ""]), $childVars);
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
     * @param string $language
     */
    public function setLanguage(string $language): void
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
     *
     * Fields for add or edit model
     * - language : Text
     *
     * @return array
     */
    public function getFields(): array
    {
        $fields = [];
        if (!empty($this->language)) {
            $fields["language"] = [
                "size" => "w-full",
                "field" => Text::create()->name("language")->label("Langue")->value($this->language)
            ];
        }
        return $fields;
    }

    public function getAll(string $columns, array $conditions = [], $orderBy = ''): ?array
    {
        $table = Table::getTable($this->table_name);
        if (isset($table)) {
            $entries = $table->findAll($columns, $conditions, $orderBy);
            return array_map(function ($entry) {
                $model = new $this();
                $model->hydrate($entry);

                return $model;
            }, $entries);
        }
        return null;
    }

    public static abstract function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array;
}