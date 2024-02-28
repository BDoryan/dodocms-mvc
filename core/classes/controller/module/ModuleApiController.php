<?php

/**
 * Not need controller extension because the render it's here
 */
abstract class ModuleApiController
{

    private Module $module;

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    public function getModule(): Module
    {
        return $this->module;
    }

    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    public function success(string $message, array $data = [])
    {
        $this->response(self::STATUS_SUCCESS, $message, $data);
    }

    public function error(string $message, array $data = [])
    {
        $this->response(self::STATUS_ERROR, $message, $data);
    }

    public function response(string $status, string $message, array $data = [])
    {
        header("Content-Type: application/json");
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], JSON_PRETTY_PRINT);
    }
}