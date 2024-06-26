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

    public const MODEL_TYPE_CMS = 'cms';
    public const MODEL_TYPE_CUSTOM = 'custom';
    public const MODEL_TYPE_MODULE = 'module';

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
     * Method called when the data of the model is fetched from the database,
     * and in this method you can add more data to the model
     *
     * @return AdminUserModel|null
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
     * Method create the data in the database and fetch the data set in a database,
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
     * Method create the data in the database (without fetch the data set in a database)
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
        return $this->updatedAt;
    }

    /**
     * Return if the model has a language attribute (column) in the database
     *
     * @return bool
     */
    public function hasLanguageAttribute(): bool
    {
        return Table::getTable($this->table_name)->hasAttributeName('language');
    }

    /**
     * Return the fields of the model for create a form (with the template of the field)
     * If you want to edit the form of this model, you can override this method
     *
     * @return array
     */
    public function getFields(): array
    {
        $fields = [];
        if ($this->hasLanguageAttribute()) {
            $fields["language"] = [
                "size" => "tw-w-6/12 tw-order-1",
                "field" =>
                    Text::create()
                        ->name("language")
                        ->label(__('admin.panel.model.language'))
                        ->value($this->language ?? Session::getLanguage())
            ];
        }
        $fields['active'] = [
            "size" => "tw-w-6/12 tw-order-1",
            "field" => Checkbox::create()
                ->name("active")
                ->placeholder(__('admin.panel.model.active.placeholder'))
                ->label(__('admin.panel.model.active.label'))
                ->value($this->active ?? false)
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
            return array_map(
            /**
             * @throws Exception
             */
                function ($entry) {
                    $model = new $this();
                    $model->hydrate($entry);
                    $model->fetch();

                    return $model;
                }, $entries);
        }
        return null;
    }

    public static abstract function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array;

    public function viewForm(): void
    {
        self::renderForm($this, [
            'action' => ($this->hasId() ? NativeRoutes::route(NativeRoutes::ADMIN_TABLE_EDIT_ENTRY, ['id' => $this->getId(), 'table' => $this->getTableName()]) : NativeRoutes::route(NativeRoutes::ADMIN_TABLE_NEW_ENTRY, ['table' => $this->getTableName()])) . '?redirection=' . Tools::getEncodedCurrentURI(),
            'buttons' => ($this->hasId() ? fetch(Application::get()->toRoot('/core/ui/views/admin/panel/sections/table/entry/set_form_button_back')) : '')
                . fetch(Application::get()->toRoot('/core/ui/views/admin/panel/sections/table/entry/set_form_button_submit'), [
                    'entry_id' => $this->hasId() ? $this->getId() : null
                ])
        ]);
    }

    public static function renderForm(Model $model, array $data = []): void
    {
        $data['table'] = $model->getTableName();
        $data['table_name'] = $model->getTableName();
        $data['model'] = $model;
        $data['entry_id'] = null;

        view(Application::get()->toRoot('/core/ui/views/admin/panel/sections/table/entry/set_form.php'), $data);
    }

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