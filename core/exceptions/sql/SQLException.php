<?php

class SQLException extends Exception
{

    private $sql;

    /**
     * @param string $sql
     */
    public function __construct(string $message = "", int $code = 0, string $sql)
    {
        $this->sql = $sql;
        parent::__construct($message, $code);
    }

    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }
}