<?php

/**
 * Class Database in namespace Veltophp\Axion.
 *
 * Structure:
 * - Implements a Singleton pattern for database connection management using PDO.
 * - Contains a private static instance (`$instance`), a private PDO object (`$pdo`), and properties for table name (`$table`), WHERE clauses (`$where`), LIMIT (`$limit`), OFFSET (`$offset`), and ORDER BY (`$orderBy`).
 * - The constructor (`__construct()`) handles database connection setup based on environment variables ('DB_CONNECTION', 'DB_DATABASE', 'DB_HOST', 'DB_USERNAME', 'DB_PASSWORD'). Supports SQLite and MySQL.
 * - Static method `getInstance()` provides access to the single instance of the Database class.
 * - Chainable methods (`table()`, `where()`, `limit()`, `offset()`, `orderBy()`) to build database queries.
 * - Private helper methods (`buildWhereSql()`, `getWhereValues()`) to construct the WHERE clause and extract its values.
 * - Public methods (`get()`, `first()`, `insert()`, `update()`, `delete()`) to execute database queries.
 *
 * How it works:
 * - The constructor establishes a database connection based on the 'DB_CONNECTION' environment variable. It supports SQLite (creating the database file if it doesn't exist) and MySQL. It sets PDO error mode to exception and default fetch mode to associative array. It uses `abort()` for connection errors or unsupported connection types.
 * - `getInstance()` ensures that only one instance of the `Database` class exists throughout the application, providing a single point of access to the database connection.
 * - `table()` sets the target table for subsequent database operations and resets the `$where` conditions.
 * - `where()` adds a WHERE condition to the query, storing the column and value in the `$where` array. Multiple `where()` calls are combined with AND.
 * - `limit()` sets the number of rows to return.
 * - `offset()` sets the starting row for pagination.
 * - `orderBy()` sets the column to order by and the direction (ASC or DESC).
 * - `buildWhereSql()` constructs the SQL WHERE clause based on the `$where` array, using prepared statement placeholders.
 * - `getWhereValues()` extracts the values from the `$where` array for prepared statement binding.
 * - `get()` executes a SELECT query, fetching all matching rows as an associative array, applying WHERE, ORDER BY, LIMIT, and OFFSET if set.
 * - `first()` executes a SELECT query with a LIMIT of 1, fetching the first matching row as an associative array or null if no match is found.
 * - `insert()` executes an INSERT query, taking an associative array of data to insert. It builds the column and placeholder lists for the SQL query and binds the values.
 * - `update()` executes an UPDATE query, taking an associative array of data to update. It builds the SET clause and uses the existing WHERE conditions. It returns the number of affected rows.
 * - `delete()` executes a DELETE query using the existing WHERE conditions. It returns the number of affected rows.
 */

namespace Velto\Axion;

use PDO;
use Exception;
use Velto\Core\Env;

class Database
{
    private static ?Database $instance = null;
    private ?PDO $pdo = null;
    private string $table;
    private array $where = [];
    private ?int $limit = null;
    private ?int $offset = null;
    private ?array $orderBy = null;

    private function __construct()
    {
        $connection = Env::get('DB_CONNECTION', 'sqlite');

        try {
            if ($connection === 'sqlite') {
                $database = base_path(Env::get('DB_DATABASE', 'axion/database/database.sqlite'));

                if (!file_exists($database)) {
                    if (!is_dir(dirname($database))) {
                        mkdir(dirname($database), 0755, true);
                    }
                    touch($database);
                }

                $this->pdo = new PDO("sqlite:$database");
            } elseif ($connection === 'mysql') {
                $host = Env::get('DB_HOST', '127.0.0.1');
                $dbname = Env::get('DB_DATABASE', 'velto');
                $user = Env::get('DB_USERNAME', 'root');
                $pass = Env::get('DB_PASSWORD', '');
                $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
            } else {
                abort(500, 'Unsupported DB_CONNECTION:'. $connection);
                // throw new Exception("Unsupported DB_CONNECTION: $connection");
            }

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            abort(500, 'Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    public function table(string $table): self
    {
        $this->table = $table;
        $this->where = [];
        return $this;
    }

    public function where(string $column, $value): self
    {
        $this->where[] = [$column, $value];
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy = [$column, strtoupper($direction)];
        return $this;
    }

    private function buildWhereSql(): string
    {
        if (empty($this->where)) return '';
        $conditions = array_map(fn($w) => "{$w[0]} = ?", $this->where);
        return 'WHERE ' . implode(' AND ', $conditions);
    }

    private function getWhereValues(): array
    {
        return array_map(fn($w) => $w[1], $this->where);
    }

    public function get(): array
    {
        $sql = "SELECT * FROM {$this->table} " . $this->buildWhereSql();

        if ($this->orderBy) {
            $sql .= " ORDER BY {$this->orderBy[0]} {$this->orderBy[1]}";
        }

        if ($this->limit !== null) {
            $sql .= " LIMIT {$this->limit}";
        }

        if ($this->offset !== null) {
            $sql .= " OFFSET {$this->offset}";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->getWhereValues());

        return $stmt->fetchAll();
    }

    public function first(): ?array
    {
        $sql = "SELECT * FROM {$this->table} " . $this->buildWhereSql() . " LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->getWhereValues());
        return $stmt->fetch() ?: null;
    }

    public function insert(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($k) => ":$k", array_keys($data)));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }

        return $stmt->execute();
    }

    public function update(array $data): int
    {
        $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $sql = "UPDATE {$this->table} SET $set " . $this->buildWhereSql();

        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }

        $stmt->execute($this->getWhereValues());

        return $stmt->rowCount();
    }

    public function delete(): int
    {
        $sql = "DELETE FROM {$this->table} " . $this->buildWhereSql();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->getWhereValues());
        return $stmt->rowCount();
    }
}
