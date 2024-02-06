<?php

class Database
{

    public static function withConfiguration($config): Database
    {
        return new Database($config["mysql"]["hostname"], $config["mysql"]["username"], $config["mysql"]["password"], $config["mysql"]["database"]);
    }

    /**
     * Try connection without database
     *
     * @return bool
     * @throws Exception
     */
    public static function getConnection($hostname, $username, $password): PDO
    {
        try {
            $pdo = new PDO("mysql:host=$hostname;", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (Exception $e) {
            Application::get()->getLogger()->printException($e);
            throw new Exception("Cannot connect to database");
        }
    }

    public static function stopConnection($connection): void
    {
        unset($connection);
    }

    public static function exec($connection, $content): void
    {
        $connection->exec($content);
    }

    private string $hostname;
    private string $username;
    private string $password;
    private string $name;

    private $connection;

    /**
     * @param string $hostname
     * @param string $username
     * @param string $password
     * @param string $name
     */
    public function __construct(string $hostname, string $username, string $password, string $name)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
    }

    public function connection(): void
    {
        $this->connection = new PDO("mysql:host=$this->hostname;dbname=$this->name", $this->username, $this->password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function insert($table, $attributes): void
    {
        $columns = implode(', ', array_keys($attributes));
        $placeholders = implode(', ', array_fill(0, count($attributes), '?'));

        $sql = "INSERT INTO  $table ($columns) VALUES ($placeholders);";
        $prepare = $this->currentConnection()->prepare($sql);
        $attributes = $this->clearBool($attributes);

        Application::get()->getLogger()->debug("Inserting into $table: " . print_r($attributes, true));
        $prepare->execute(array_values($attributes));
    }

    public function update($table, $attributes, $conditions): void
    {
        $columns_string = implode(', ', array_map(function ($key, $value) {
            return "$key = :$key";
        }, array_keys($attributes), $attributes));

        $conditions_string = implode(', ', array_map(function ($key, $value) {
            return "$key = :$key";
        }, array_keys($conditions), $conditions));

        $sql = "UPDATE $table SET $columns_string WHERE $conditions_string;";
        $prepare = $this->currentConnection()->prepare($sql);
        $merge = array_merge($attributes, $conditions);
        $merge = $this->clearBool($merge);
        Application::get()->getLogger()->debug("Updating $table: " . print_r($merge, true));
        $prepare->execute($merge);
    }

    private function clearBool($array): array
    {
        foreach ($array as $key => $value) {
            if (is_bool($value)) {
                $array[$key] = $value ? 1 : 0;
            }
        }
        return $array;
    }

    public function count($table, $conditions = []): int
    {
        $conditions_string = implode(' AND ', array_map(function ($key, $value) {
            return "$key = :$key";
        }, array_keys($conditions), $conditions));

        $sql = "SELECT COUNT(*) FROM $table";
        if (!empty($conditions_string)) {
            $sql .= " WHERE $conditions_string";
        }
        $prepare = $this->currentConnection()->prepare($sql);
        $prepare->execute($conditions);
        return $prepare->fetchColumn();
    }

    private function prepareSelect($table, $columns = '*', $conditions = [], $orderBy = "", $operators = [], $limit = null)
    {
        try {
            $query = "SELECT $columns FROM $table";

            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", array_map(function ($key, $value) use ($operators) {
                        $operator = $operators[$key] ?? "=";
                        return "$key $operator :$key";
                    }, array_keys($conditions), $conditions));
            }

            if (!empty($orderBy)) {
                $query .= " ORDER BY $orderBy";
            }

            if ($limit !== null) {
                $query .= " LIMIT $limit";
            }

            $prepare = $this->connection->prepare($query);

            Application::get()->getLogger()->debug("Executing query: $query");
            $prepare->execute($conditions);
            return $prepare;
        } catch (PDOException $e) {
        }
        return null;
    }

    public function execute($query): void
    {
        self::exec($this->connection, $query);
    }

    public function find($table, $columns = '*', $conditions = [], $orderBy = null, $limit = null)
    {
        $prepare = $this->prepareSelect($table, $columns, $conditions, $orderBy, $limit);
        if (!empty($prepare))
            return $prepare->fetch(PDO::FETCH_ASSOC);
        return null;
    }

    public function existTable($table): bool
    {
        $query = "SHOW TABLES LIKE '$table'";
        $stmt = $this->connection->query($query);
        return $stmt->rowCount() > 0;
    }

    public function lastInsertId(): int
    {
        return $this->connection->lastInsertId();
    }

    public function findAll($table, $columns = '*', $conditions = [], $orderBy = null, $operators = [], $limit = null)
    {
        $prepare = $this->prepareSelect($table, $columns, $conditions, $orderBy, $operators, $limit);
        if (!empty($prepare))
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        return [];
    }

    public function fetch($sql, $params = [])
    {
        $prepare = $this->connection->prepare($sql);
        $prepare->execute($params);
        return $prepare->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql, $params = [])
    {
        $prepare = $this->connection->prepare($sql);
        $prepare->execute($params);
        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }

    public function showTables()
    {
        $query = "SHOW TABLES";
        $stmt = $this->connection->query($query);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function delete($table, $conditions = []): bool
    {
        $conditions_string = implode(' AND ', array_map(function ($key, $value) {
            return "$key = :$key";
        }, array_keys($conditions), $conditions));

        $sql = "DELETE FROM $table WHERE $conditions_string;";
        $prepare = $this->currentConnection()->prepare($sql);
        return $prepare->execute($conditions);
    }

    public function describe($table)
    {
        $query = "DESCRIBE $table";
        $stmt = $this->connection->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function closeConnection(): void
    {
        $this->connection = null;
    }

    /**
     * @return mixed
     */
    public function currentConnection(): PDO
    {
        return $this->connection;
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string {
        $sql = "SELECT VERSION()";
        $prepare = $this->connection->prepare($sql);
        $prepare->execute();
        return $prepare->fetchColumn();
    }
}