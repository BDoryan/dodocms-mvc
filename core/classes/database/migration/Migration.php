<?php

class Migration {

    private string $sql;
    private string $destination;

    /**
     * @param string $sql
     * @param string $destination
     */
    public function __construct(string $destination, string $sql = '')
    {
        $this->destination = $destination;
        $this->sql = $sql;
    }

    public function load() {
        $this->sql = file_get_contents($this->destination);
    }

    public function save() {
        if (!file_exists(dirname($this->destination)))
            mkdir(dirname($this->destination), 0777, true);
        file_put_contents($this->destination, $this->sql);
    }

    public function execute() {
        Application::get()->getDatabase()->execute($this->sql);
    }

    public function getSql(): string
    {
        return $this->sql;
    }

    public function getLastModification(): int {
        return filemtime($this->destination);
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    public static function create(string $dir, string $sql = ''): Migration {
        $destination = rtrim($dir, '/').'/'.time().'.sql';
        return new Migration($destination, $sql);
    }

    public static function getMigrations(string $dir, ?int $after = 0): array {
        $migrations = [];
        foreach (glob(rtrim($dir, '/').'/*.sql') as $file) {
            if (filemtime($file) > $after) {
                $migration = new Migration($file);
                $migration->load();
                $migrations[] = $migration;
            }
        }
        return $migrations;
    }
}