<?php

abstract class ModelAssociated extends Model
{

    /**
     * This class is used to manage associate and dissociate resources
     * @param $table_name
     */
    public function __construct($table_name)
    {
        parent::__construct($table_name);
    }

    public function create(): bool
    {
        if (!parent::create()) return false;

        /** @var ModelAssociation $associate */
        foreach ($this->associates() as $variable => $associate) {
            $associations = $this->{$variable};
            /** @var Model $association */
            foreach ($associations as $association) {
                $this->associate($associate, $association->getId());
            }
        }
        return true;
    }

    /**
     * Delete the data of the current model and after delete all associations
     *
     * @return void
     */
    public function deleteModelAndAssociations()
    {
        /** @var ModelAssociation $associate */
        foreach ($this->associates() as $variable => $associate) {
            /** @var Model $association */
            foreach ($this->{$variable} as $association) {
                $association->delete();
                unset($association);
            }
        }

        $this->delete();
    }

    /**
     * Disassociate all associations and after delete the data of the current model
     *
     * @return bool
     */
    public function delete(): bool
    {
        /** @var ModelAssociation $associate */
        foreach ($this->associates() as $variable => $associate) {
            $this->dissociates($associate, $associate->getForeignAssociatedKey());
        }

        if (!parent::delete()) return false;

        return true;
    }

    /**
     * Update the data of the current model and after compare current associations with the database association to update them
     *
     * @return void
     * @throws Exception
     */
    public function update(): bool
    {
        /** @var ModelAssociation $associate */
        foreach ($this->associates() as $variable => $associate) {
            $associations = $this->associations($associate);

            /** @var Model $association */
            foreach ($associations as $association) {
                if (Tools::containsItems($this->{$variable}, "getId", $association->getId()))
                    continue;
                $this->dissociate($associate, $association->getId());
            }
            foreach ($this->{$variable} as $association) {
                if (empty($association))
                    continue;
                if (Tools::containsItems($associations, "getId", $association->getId()))
                    continue;
                $this->associate($associate, $association->getId());
            }
        }

        if (!parent::update()) return false;

        return true;
    }

    public function filteredAttributes(): array
    {
        $filtered = parent::filteredAttributes();
        foreach ($this->associates() as $variable => $associate) {
            $filtered[$variable] = "";
        }
        return $filtered;
    }

    /**
     * Fetch the data of the current model and after fetch all data of associations
     *
     * @return Model|null
     * @throws Exception
     */
    public function fetch(): ?Model
    {
        if (!parent::fetch()) return $this;

        foreach ($this->associates() as $variable => $associate) {
            $this->{$variable} = $this->associations($associate);
        }

        return $this;
    }

    public function hydrate(array $data): void
    {
        /** @var ModelAssociation $associate */
        foreach ($this->associates() as $variable => $associate) {
            if (isset($data[$variable])) {
                $associations = $data[$variable];
                if (Tools::startsWith($associations, ','))
                    $associations = substr($associations, 1);

                $this->{$variable} = empty($associations) ? [] : array_map(function ($association) use ($associate) {
                    $model = Model::getModel(Table::getTable($associate->getAssociatedTable()));
                    $model->id($association)->fetch();
                    return $model;
                }, explode(',', $associations));
                unset($data[$variable]);
            }
        }

        parent::hydrate($data);
    }

    /**
     * List of models associated to the current model
     *
     * @return array|null
     */
    public abstract function associates(): ?array;

    /**
     * Select all model entry associated to the current model
     *
     * @param ModelAssociation $association the association of the model
     * @return array|null
     * @throws Exception
     */
    public function associations(ModelAssociation $association): ?array
    {
        $associated_table = $association->getAssociatedTable();
        $association_table = $association->getAssociationTable();
        $foreign_associated_key = $association->getForeignAssociatedKey();
        $foreign_association_key = $association->getForeignAssociationKey();

        $sql = "
            SELECT associated_table.* 
            FROM " . $association_table . " 
            JOIN " . $associated_table . " associated_table  
            ON " . $association_table . "." . $foreign_association_key . " = associated_table.id 
            WHERE " . $association_table . "." . $foreign_associated_key . " = ?";

        $database = Application::get()->getDatabase();
        $results = $database->fetchAll($sql
            , [$this->id]
        );

        if (is_bool($results)) return null;
        return array_map(function ($result) use ($associated_table) {
            $association_table = Table::getTable($associated_table);
            $association = Model::getModel($association_table);
            $association->hydrate($result);
            return $association;
        }, $results);
    }

    /**
     * Dissociate all model entry of the current model
     *
     * @param ModelAssociation $association the association of the model
     * @param string $foreign_key the foreign key of the model
     * @return void
     */
    public function dissociates(ModelAssociation $association, string $foreign_key): void
    {
        $database = Application::get()->getDatabase();
        $database->delete($association->getAssociationTable(), [$foreign_key => $this->id]);
    }

    /**
     * Dissociate a model entry from the current model
     *
     * @param ModelAssociation $association the association of the model
     * @param int $id
     * @return void
     */
    public function dissociate(ModelAssociation $association, int $id): void
    {
        $database = Application::get()->getDatabase();
        $database->delete($association->getAssociationTable(), [$association->getForeignAssociatedKey() => $this->id, $association->getForeignAssociationKey() => $id]);
    }

    /**
     * Associate a model entry to the current model
     *
     * @param ModelAssociation $association the association of the model
     * @param int $id
     * @return void
     */
    public function associate(ModelAssociation $association, int $id): void
    {
        $database = Application::get()->getDatabase();
        $database->insert($association->getAssociationTable(), [$association->getForeignAssociatedKey() => $this->id, $association->getForeignAssociationKey() => $id]);
    }

    public static abstract function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array;

}