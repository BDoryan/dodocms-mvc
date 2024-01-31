<?php

class ModelAssociation
{

    private string $associated_table;
    private string $association_table;
    private string $foreign_associated_key;
    private string $foreign_association_key;

    /**
     * @param string $associated_table the table name of model
     * @param string $association_table the table name of association of models
     * @param string $foreign_associated_key the foreign key of the model
     * @param string $foreign_association_key the foreign key of the association
     */
    public function __construct(string $associated_table, string $association_table, string $foreign_associated_key, string $foreign_association_key)
    {
        $this->associated_table = $associated_table;
        $this->association_table = $association_table;
        $this->foreign_associated_key = $foreign_associated_key;
        $this->foreign_association_key = $foreign_association_key;
    }

    public function getAssociatedTable(): string
    {
        return $this->associated_table;
    }

    public function setAssociatedTable(string $associated_table): void
    {
        $this->associated_table = $associated_table;
    }

    public function getAssociationTable(): string
    {
        return $this->association_table;
    }

    public function setAssociationTable(string $association_table): void
    {
        $this->association_table = $association_table;
    }

    public function getForeignAssociatedKey(): string
    {
        return $this->foreign_associated_key;
    }

    public function setForeignAssociatedKey(string $foreign_associated_key): void
    {
        $this->foreign_associated_key = $foreign_associated_key;
    }

    public function getForeignAssociationKey(): string
    {
        return $this->foreign_association_key;
    }

    public function setForeignAssociationKey(string $foreign_association_key): void
    {
        $this->foreign_association_key = $foreign_association_key;
    }
}