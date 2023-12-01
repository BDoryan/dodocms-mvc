<?php

class FileUnauthorizedException extends Exception
{

    private ?string $file_name;
    public function __construct($message = "", $file_name = null, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->file_name = $file_name;
    }

    /**
     * @return string
     */
    public function getFileName(): ?string
    {
        return $this->file_name;
    }
}