<?php

class Configuration
{

    protected string $path;
    protected array $configurations = [];

    public function __construct(string $path)
    {
        if (!Tools::endsWith($path, ".json"))
            $path .= ".json";

        $this->path = $path;
    }

    /**
     * @throws Exception
     */
    public function load(): void
    {
        if (file_exists($this->path)) {
            $this->configurations = json_decode(file_get_contents($this->path), true);
            return;
        }
        throw new Exception("File not found : " . $this->path . " !");
    }

    public function get(string $key = null)
    {
        if (!isset($this->configurations)) {
            $this->load();
        }

        if ($key == null)
            return $this->configurations;
        return $this->configurations[$key] ?? null;
    }

    public function set(string $key, $value): void
    {
        $this->configurations[$key] = $value;
    }

    public function save(): void
    {
        if (file_exists($this->path)) {
            file_put_contents($this->path, json_encode($this->configurations, JSON_PRETTY_PRINT));
        } else {
            throw new Exception("File not found : " . $this->path . " !");
        }
    }

    public function toArray(): array
    {
        return $this->configurations;
    }
}