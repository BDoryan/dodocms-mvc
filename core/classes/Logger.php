<?php

class Logger
{

    private string $file;
    private bool $debug = false;
    private array $logs = [];
    private $callback;

    public function __construct(string $file, $debug = false)
    {
        $this->file = $file;
        $this->debug = $debug;

        $dir = dirname($file);
        if (!file_exists($dir))
            mkdir($dir, 0775, true);
    }

    public function setDebug(bool $debug = true): void
    {
        $this->debug = $debug;
    }

    public function hasDebug(): bool
    {
        return $this->debug;
    }

    public function callback(callable $callback): Logger
    {
        $this->callback = $callback;
        return $this;
    }

    public function debug(string $message): void
    {
        if (!$this->debug)
            return;
        $this->log("[DEBUG] $message");
    }

    public function info(string $message): void
    {
        $this->log("[INFO] $message");
    }

    public function warning(string $message): void
    {
        $this->log("[WARNING] $message");
    }

    public function error(string $message): void
    {
        $this->log("[ERROR] $message");
    }

    public function printError(Error $e): void
    {
        $this->error($e->getMessage());
        $this->error(Tools::removeFirstSlash($e->getFile()) . ":" . $e->getLine());
        foreach ($e->getTrace() as $log) {
            $this->error(Tools::removeFirstSlash($log['file'] ?? '') . ":" . $log['line'] ?? '');
        }
    }

    public function printException(Exception $e): void
    {
        $this->log("[EXCEPTION] " . $e->getMessage());
        $this->log("[EXCEPTION] " . Tools::removeFirstSlash($e->getFile()) . ":" . $e->getLine());
        foreach ($e->getTrace() as $log) {
            $this->log("[EXCEPTION] " . Tools::removeFirstSlash($log['file'] ?? '') . ":" . ($log['line'] ?? ''));
        }
    }

    public function logsToHTML()
    {
        if (empty($this->logs))
            return 'empty';
        return implode('<br>', $this->logs);
    }

    private function log(string $message): void
    {
        $date = date("Y-m-d H:i:s");
        $message = "$date: $message\n";

        if (isset($this->callback))
            $this->callback($message);

        $message = htmlspecialchars($message);

        $this->logs[] = $message;

        $exist = file_exists($this->file);
        file_put_contents($this->file, $message, FILE_APPEND);
        if (!$exist)
            chmod($this->file, 0660);
    }

    public function clear(): void
    {
        file_put_contents($this->file, "");
    }
}