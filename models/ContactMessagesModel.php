<?php

Autoloader::require("core/classes/database/model/Model.php");

class ContactMessagesModel extends Model
{
    public const TABLE_NAME = "ContactMessages";

    private $firstname;
    private $lastname;
    private $message;
    private $email;
    public function __construct($firstname = "", $lastname = "", $message = "", $email = "")
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->message = $message;
        $this->email = $email;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

/** Warning: if you want create or edit entries you need to create the form with a override of getFields(); */

    public static function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array
    {
        return (new ContactMessagesModel())->getAll($columns, $conditions, $orderBy);
    }
}

Table::$models[ContactMessagesModel::TABLE_NAME] = ContactMessagesModel::class;