<?php

class SQLException extends Exception
{

    private $sql;

    /**
     * @param string $sql
     */
    public function __construct(string $message = "", $code = '', string $sql)
    {
        $this->sql = $sql;
        parent::__construct($message, is_int($code) ? $code : 0);
    }

    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }
}