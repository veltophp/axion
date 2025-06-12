<?php

/**
 * Class Model in namespace Veltophp\Axion.
 *
 * Structure:
 * - Extends basic database interaction capabilities using PDO.
 * - Manages a PDO connection (`$pdo`), the associated database table (`$table`),
 * an array of fillable attributes (`$fillable`), query conditions (`$conditions`),
 * and a flag to enable timestamps (`$timestamps`).
 * - Includes a constructor (`__construct()`) to initialize the database connection and boot timestamp functionality.
 * - Provides static methods for common database operations: `create()`, `all()`, `find()`, `findBy()`, `update()`, `delete()`, `where()`, `first()`, `firstWhere()`, `count()`, `paginate()`. These act as static entry points to instance methods.
 * - Contains protected instance methods for core database interactions: `init()`, `bootTimestamps()`, `insert()`, `getAll()`, `findById()`, `findByColumn()`, `updateRecord()`, `deleteRecord()`, `getFirst()`, `getFirstWhere()`, `getCount()`, `getPaginated()`.
 * - Includes protected instance methods with timestamp support: `insertWithTimestamps()`, `updateRecordWithTimestamps()`.
 *
 * How it works:
 * - `__construct()`: Initializes the PDO connection by calling `init()` and sets up timestamp handling with `bootTimestamps()`.
 * - `init()`: Establishes a PDO connection to the SQLite database specified in the configuration. Sets error mode to exception.
 * - `bootTimestamps()`: Automatically adds 'created_at' and 'updated_at' to the `$fillable` array if `$timestamps` is true and they are not already present.
 * - Static methods create a new instance of the `Model` and call the corresponding instance method, providing a convenient static API.
 * - `insert()`: Inserts a new record into the table using the provided data, respecting the `$fillable` attributes. Uses prepared statements for security.
 * - `getAll()`: Retrieves all records from the table.
 * - `findById()`: Retrieves a single record based on its primary key (`id`).
 * - `findByColumn()`: Retrieves a single record based on a specific column and value.
 * - `updateRecord()`: Updates existing records based on a WHERE clause (can be an ID or an array of conditions), using only the `$fillable` attributes. Uses prepared statements.
 * - `deleteRecord()`: Deletes records based on a WHERE clause (can be an ID or an array of conditions). Uses prepared statements.
 * - `where()`: Starts building a conditional query, adding an 'AND' condition. Returns the model instance for method chaining.
 * - `orWhere()`: Adds an 'OR' condition to the query. Returns the model instance for method chaining.
 * - `get()`: Executes the built conditional query and returns all matching records as an array of objects.
 * - `first()`: Retrieves the first record from the table.
 * - `firstWhere()`: Retrieves the first record matching the given conditions.
 * - `count()`: Returns the total number of records in the table.
 * - `paginate()`: Retrieves records with pagination, returning an array containing the data, total count, per-page limit, current page, and last page number.
 * - `insertWithTimestamps()`: Calls `insert()` after automatically adding `created_at` and `updated_at` timestamps if `$timestamps` is true.
 * - `updateRecordWithTimestamps()`: Calls `updateRecord()` after automatically updating the `updated_at` timestamp if `$timestamps` is true.
 */

namespace Velto\Axion;

use PDO;
use DateTimeImmutable;
use Velto\Core\Env;

#[\AllowDynamicProperties]
class Model
{
    protected PDO $pdo;
    protected string $table;
    protected array $fillable = [];
    protected array $conditions = [];
    protected bool $timestamps = true;

    
    public function __construct()
    {
        $this->init();
        $this->bootTimestamps();
    }

    protected function init(): void
    {
        if (!isset($this->pdo)) {
            $driver = Env::get('DB_CONNECTION', 'sqlite');
            $host = Env::get('DB_HOST', '127.0.0.1');
            $dbname = Env::get('DB_DATABASE', 'database');
            $username = Env::get('DB_USERNAME', 'root');
            $password = Env::get('DB_PASSWORD', '');

            switch ($driver) {
                case 'mysql':
                    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
                    break;
                case 'pgsql':
                    $dsn = "pgsql:host=$host;dbname=$dbname";
                    break;
                default: 
                    $dsn = 'sqlite:' . BASE_PATH . '/' . $dbname;
                    $username = null;
                    $password = null;
                    break;
            }

            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }
    protected function bootTimestamps(): void
    {
        if ($this->timestamps && !in_array('created_at', $this->fillable)) {
            $this->fillable[] = 'created_at';
        }
        if ($this->timestamps && !in_array('updated_at', $this->fillable)) {
            $this->fillable[] = 'updated_at';
        }
    }
    // === Static entry point ===
    public static function create(array $data): bool
    {
        return (new static())->insertWithTimestamps($data);
    }
    public static function all(): array
    {
        return (new static())->getAll();
    }
    public static function find($id): ?object
    {
        return (new static())->findById($id);
    }
    public static function findBy(string $column, $value): ?object
    {
        return (new static())->findByColumn($column, $value);
    }
    public function update(array|string $whereOrData, ?array $data = null): bool
    {
        if (is_array($data)) {
            return $this->updateRecordWithTimestamps($whereOrData, $data);
        }

        return $this->updateRecordWithTimestamps($this->conditions ?? [], $whereOrData);
    }
    public static function updateBy(string $column, $value, array $data): bool
    {
        $instance = new static();
        $where = [$column => $value];
        return $instance->updateRecordWithTimestamps($where, $data);
    }
    public static function delete(array|string|int $where = []): bool
    {
        $instance = new static();
    
        if (!empty($where)) {
            return $instance->deleteRecord($where);
        }
    
        if (!empty($instance->conditions)) {
            $compiled = [];
            foreach ($instance->conditions as $condition) {
                if ($condition['type'] === 'AND') {
                    $compiled[$condition['column']] = $condition['value'];
                }
            }
    
            if (empty($compiled)) {
                throw new \Exception("Delete requires at least one condition.");
            }
    
            return $instance->deleteRecord($compiled);
        }
    
        throw new \Exception("Delete operation requires a WHERE clause to avoid deleting all records.");
    }
    public static function where(string $column, $operatorOrValue, $value = null): static
    {
        $instance = new static();
        return $instance->whereInternal('AND', $column, $operatorOrValue, $value);
    }
    public function orWhere(string $column, $operatorOrValue, $value = null): static
    {
        return $this->whereInternal('OR', $column, $operatorOrValue, $value);
    }
    protected function whereInternal(string $type, string $column, $operatorOrValue, $value = null): static
    {
        if ($value === null) {
            $this->conditions[] = [
                'type' => $type,
                'column' => $column,
                'operator' => '=',
                'value' => $operatorOrValue
            ];
        } else {
            $this->conditions[] = [
                'type' => $type,
                'column' => $column,
                'operator' => strtoupper($operatorOrValue),
                'value' => $value
            ];
        }

        return $this;
    }
    public function get(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        if (!empty($this->conditions)) {
            $clauses = [];
            foreach ($this->conditions as $index => $cond) {
                if (!is_array($cond) || !isset($cond['column'], $cond['value'], $cond['type'])) {
                    continue;
                }

                $paramKey = ":param$index";
                $prefix = $index === 0 ? '' : $cond['type'] . ' ';
                $operator = $cond['operator'] ?? '=';
                $clauses[] = "$prefix{$cond['column']} $operator $paramKey";
                $params[$paramKey] = $cond['value'];
            }
            if ($clauses) {
                $sql .= ' WHERE ' . implode(' ', $clauses);
            }
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (!$data) return [];

        $caller = get_called_class();
        if (is_subclass_of($caller, \Velto\Axion\Model::class)) {
            $models = [];
            $ref = new \ReflectionClass($caller);
            foreach ($data as $row) {
                $model = new $caller();
                foreach ((array) $row as $key => $value) {
                    if ($ref->hasProperty($key)) {
                        $prop = $ref->getProperty($key);
                        $type = $prop->getType();
                        if (!$type || ($type instanceof \ReflectionNamedType && $type->allowsNull()) || $value !== null) {
                            $model->{$key} = $value;
                        }
                    } else {
                        $model->{$key} = $value;
                    }
                }
                $models[] = $model;
            }
            return $models;
        }

        // fallback: return array of stdClass
        return $data;
    }

    public function first(): ?object
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        if (!empty($this->conditions)) {
            $clauses = [];
            foreach ($this->conditions as $index => $cond) {
                $paramKey = ":param$index";
                $prefix = $index === 0 ? '' : $cond['type'] . ' ';
                $clauses[] = "$prefix{$cond['column']} {$cond['operator']} $paramKey";
                $params[$paramKey] = $cond['value'];
            }
            $sql .= ' WHERE ' . implode(' ', $clauses);
        }

        $sql .= ' LIMIT 1';

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$data) return null;

        // Deteksi: jika dipanggil dari subclass Model, kembalikan sebagai instance model
        $caller = get_called_class();
        if (is_subclass_of($caller, \Velto\Axion\Model::class)) {
            $model = new $caller();
            foreach ((array) $data as $key => $value) {
                $model->{$key} = $value;
            }
            return $model;
        }

        // Default: return object biasa
        return $data;
    }

    public function firstWhere(array $conditions): ?object
    {
        $instance = new static();

        foreach ($conditions as $column => $value) {
            $instance->where($column, $value);
        }

        return $instance->first();
    }
    public function count(): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $params = [];

        if (!empty($this->conditions)) {
            $clauses = [];
            foreach ($this->conditions as $index => $cond) {
                $paramKey = ":param$index";
                $prefix = $index === 0 ? '' : $cond['type'] . ' ';
                $clauses[] = "$prefix{$cond['column']} = $paramKey";
                $params[$paramKey] = $cond['value'];
            }
            $sql .= ' WHERE ' . implode(' ', $clauses);
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return (int) ($result->count ?? 0);
    }
    public function paginate(int $perPage = 10, int $page = 1): array
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        if (!empty($this->conditions)) {
            $clauses = [];
            foreach ($this->conditions as $index => $cond) {
                $paramKey = ":param$index";
                $prefix = $index === 0 ? '' : $cond['type'] . ' ';
                $clauses[] = "$prefix{$cond['column']} = $paramKey";
                $params[$paramKey] = $cond['value'];
            }
            $sql .= ' WHERE ' . implode(' ', $clauses);
        }

        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);

        // Bind dynamic parameters
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
    }

    public function belongsTo(string $relatedClass, string $foreignKey, string $ownerKey): ?object
    {
        if (!property_exists($this, $foreignKey)) {
            return null;
        }

        $related = new $relatedClass();
        return $related->where($ownerKey, $this->{$foreignKey})->first();
    }

    public function hasOne(string $relatedClass, string $foreignKey, string $localKey): ?object
    {
        if (!property_exists($this, $localKey)) {
            return null;
        }

        $related = new $relatedClass();
        return $related->where($foreignKey, $this->{$localKey})->first();
    }


    public function hasMany(string $relatedClass, string $foreignKey, string $localKey): array
    {
        if (!property_exists($this, $localKey)) {
            return [];
        }

        $related = new $relatedClass();
        return $related->where($foreignKey, $this->{$localKey})->get();
    }

    // === Internal instance methods with timestamps ===
    protected function insertWithTimestamps(array $data): bool
    {
        if ($this->timestamps) {
            $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');
            $data['created_at'] = $now;
            $data['updated_at'] = $now;
        }
        return $this->insert($data);
    }
    protected function updateRecordWithTimestamps($where, array $data): bool
    {
        if ($this->timestamps) {
            $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');
            $data['updated_at'] = $now;
        }
        return $this->updateRecord($where, $data);
    }
    // === Internal instance methods (original) ===
    protected function insert(array $data): bool
    {
        $fillableData = array_intersect_key($data, array_flip($this->fillable));
        $columns = implode(', ', array_keys($fillableData));
        $placeholders = implode(', ', array_map(fn($v) => ":$v", array_keys($fillableData)));
    
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
    
        foreach ($fillableData as $key => $value) {
            if ($this->isIntegerColumn($key)) {
                if ($value === '') {
                    $value = null; // atau 0 kalau kolom NOT NULL
                }
                $paramType = PDO::PARAM_INT;
            } elseif (is_null($value)) {
                $paramType = PDO::PARAM_NULL;
            } else {
                $paramType = PDO::PARAM_STR;
            }
        
            $stmt->bindValue(":$key", $value, $paramType);
        }        
    
        return $stmt->execute();
    }
    protected function isIntegerColumn(string $column): bool
    {
        $integerColumns = ['id', 'email_verified'];
        return in_array($column, $integerColumns);
    }
    protected function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
    }
    protected function findById($id): ?object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }
    protected function findByColumn(string $column, $value): ?object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value");
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }
    // protected function updateRecord($where, array $data): bool
    // {
    //     $fillableData = array_intersect_key($data, array_flip($this->fillable));
    //     if (empty($fillableData)) {
    //         return false;
    //     }
    //     $setParts = [];
    //     foreach ($fillableData as $key => $value) {
    //         $setParts[] = "$key = :set_$key";
    //     }
    //     $setClause = implode(', ', $setParts);
    //     $whereClause = '';
    //     $params = [];
    //     if (is_scalar($where)) {
    //         $whereClause = 'id = :where_id';
    //         $params[':where_id'] = $where;
    //     } elseif (is_array($where)) {
    //         $parts = [];
    //         foreach ($where as $key => $value) {
    //             $paramKey = ':where_' . $key;
    //             $parts[] = "$key = $paramKey";
    //             $params[$paramKey] = $value;
    //         }
    //         $whereClause = implode(' AND ', $parts);
    //     } else {
    //         return false;
    //     }
    //     foreach ($fillableData as $key => $value) {
    //         $params[":set_$key"] = $value;
    //     }
    //     $sql = "UPDATE {$this->table} SET $setClause WHERE $whereClause";
    //     $stmt = $this->pdo->prepare($sql);
    //     return $stmt->execute($params);
    // }

    protected function updateRecord($where, array $data): bool
    {
        $fillableData = array_intersect_key($data, array_flip($this->fillable));
        if (empty($fillableData)) {
            return false;
        }

        $setParts = [];
        foreach ($fillableData as $key => $value) {
            $setParts[] = "$key = :set_$key";
        }
        $setClause = implode(', ', $setParts);
        $params = [];
        $whereClause = '';

        // ✅ Tangani format kondisi chaining dari Velto
        if (isset($where[0]) && isset($where[0]['column']) && isset($where[0]['operator'])) {
            $parts = [];
            foreach ($where as $index => $condition) {
                $paramKey = ":where_{$condition['column']}_{$index}";
                $parts[] = "{$condition['column']} {$condition['operator']} $paramKey";
                $params[$paramKey] = $condition['value'];
            }
            $whereClause = implode(' AND ', $parts);
        }
        // Tangani format array biasa
        elseif (is_array($where)) {
            $parts = [];
            foreach ($where as $key => $value) {
                $paramKey = ':where_' . $key;
                $parts[] = "$key = $paramKey";
                $params[$paramKey] = $value;
            }
            $whereClause = implode(' AND ', $parts);
        }
        // Tangani format scalar
        elseif (is_scalar($where)) {
            $whereClause = 'id = :where_id';
            $params[':where_id'] = $where;
        } else {
            return false;
        }

        // Gabungkan parameter update
        foreach ($fillableData as $key => $value) {
            $params[":set_$key"] = $value;
        }

        $sql = "UPDATE {$this->table} SET $setClause WHERE $whereClause";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    protected function deleteRecord($where): bool
    {
        if (is_scalar($where)) {
            $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
            return $stmt->execute([':id' => $where]);
        }
        if (is_array($where)) {
            $parts = [];
            $params = [];
            foreach ($where as $key => $value) {
                $paramKey = ":$key";
                $parts[] = "$key = $paramKey";
                $params[$paramKey] = $value;
            }
            $whereClause = implode(' AND ', $parts);
            $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE $whereClause");
            return $stmt->execute($params);
        }
        return false;
    }
    protected function getFirst(): ?object
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} LIMIT 1");
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }
    protected function getFirstWhere(array $conditions): ?object
    {
        $whereParts = [];
        $params = [];
        foreach ($conditions as $key => $value) {
            $whereParts[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        $whereClause = implode(' AND ', $whereParts);
        $sql = "SELECT * FROM {$this->table} WHERE $whereClause LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }
    protected function getCount(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }
    protected function getPaginated(int $perPage, int $page): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_OBJ);
        $totalStmt = $this->pdo->query("SELECT COUNT(*) as total FROM {$this->table}");
        $total = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];
        return [
            'data' => $items,
            'total' => (int) $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
        ];
    }

    
}
