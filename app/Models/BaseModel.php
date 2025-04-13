<?php

namespace App\Models;

use Config\Database;

/**
 * BaseModel - A foundation class for all models in MVC architecture with PostgreSQL
 * 
 * This class provides core database operations and common functionality
 * that all model classes can inherit from, specifically designed for PostgreSQL.
 * Features include soft deletes and automatic timestamp handling.
 */
class BaseModel
{
    /**
     * Database connection
     * @var \PDO
     */
    protected $db;
    
    /**
     * Table name for this model
     * @var string
     */
    protected $table;
    
    /**
     * Primary key column name
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * Fillable attributes (for mass assignment)
     * @var array
     */
    protected $fillable = [];
    
    /**
     * Whether to use soft deletes
     * @var bool
     */
    protected $useSoftDeletes = false;
    
    /**
     * Column name for soft deletes
     * @var string
     */
    protected $deletedAtColumn = 'deleted_at';
    
    /**
     * Whether to automatically manage timestamps
     * @var bool
     */
    protected $timestamps = false;
    
    /**
     * Column name for creation timestamp
     * @var string
     */
    protected $createdAtColumn = 'created_at';
    
    /**
     * Column name for update timestamp
     * @var string
     */
    protected $updatedAtColumn = 'updated_at';
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getDb() {
        return $this->db;
    }
    
    /**
     * Find a record by its primary key
     * 
     * @param int $id
     * @return array|null
     */
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        
        if ($this->useSoftDeletes) {
            $sql .= " AND {$this->deletedAtColumn} IS NULL";
        }
        
        $sql .= " LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
    
    /**
     * Get all records from the table
     * 
     * @return array
     */
    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        
        if ($this->useSoftDeletes) {
            $sql .= " WHERE {$this->deletedAtColumn} IS NULL";
        }
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Create a new record
     * 
     * @param array $data
     * @return int Last inserted ID
     */
    public function create(array $data)
    {
        // Filter data to only include fillable fields
        $data = array_intersect_key($data, array_flip($this->fillable));
        
        // Add timestamps if enabled
        if ($this->timestamps) {
            $now = date('Y-m-d H:i:s');
            $data[$this->createdAtColumn] = $now;
            $data[$this->updatedAtColumn] = $now;
        }
        
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders) RETURNING {$this->primaryKey}");
        $stmt->execute($data);
        
        $result = $stmt->fetch();
        return $result[$this->primaryKey];
    }
    
    /**
     * Update an existing record
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        // Filter data to only include fillable fields
        $data = array_intersect_key($data, array_flip($this->fillable));
        
        // Add updated_at timestamp if enabled
        if ($this->timestamps) {
            $data[$this->updatedAtColumn] = date('Y-m-d H:i:s');
        }
        
        $setClause = [];
        foreach (array_keys($data) as $column) {
            $setClause[] = "$column = :$column";
        }
        $setClause = implode(', ', $setClause);
        
        $data[$this->primaryKey] = $id;
        
        $sql = "UPDATE {$this->table} SET $setClause WHERE {$this->primaryKey} = :{$this->primaryKey}";
        
        if ($this->useSoftDeletes) {
            $sql .= " AND {$this->deletedAtColumn} IS NULL";
        }
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    
    /**
     * Delete a record (hard delete)
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        // If soft deletes are enabled, use softDelete instead
        if ($this->useSoftDeletes) {
            return $this->softDelete($id);
        }
        
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Soft delete a record by setting deleted_at timestamp
     * 
     * @param int $id
     * @return bool
     */
    public function softDelete($id)
    {
        if (!$this->useSoftDeletes) {
            return $this->delete($id);
        }
        
        $data = [
            $this->primaryKey => $id,
            'deleted_at' => date('Y-m-d H:i:s')
        ];
        
        $stmt = $this->db->prepare("UPDATE {$this->table} SET {$this->deletedAtColumn} = :deleted_at WHERE {$this->primaryKey} = :{$this->primaryKey} AND {$this->deletedAtColumn} IS NULL");
        return $stmt->execute($data);
    }
    
    /**
     * Restore a soft-deleted record
     * 
     * @param int $id
     * @return bool
     */
    public function restore($id)
    {
        if (!$this->useSoftDeletes) {
            return false;
        }
        
        $stmt = $this->db->prepare("UPDATE {$this->table} SET {$this->deletedAtColumn} = NULL WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Force delete a soft-deleted record
     * 
     * @param int $id
     * @return bool
     */
    public function forceDelete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Include soft-deleted records in the query
     * 
     * @return $this
     */
    public function withTrashed()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }
    
    /**
     * Get only soft-deleted records
     * 
     * @return array
     */
    public function onlyTrashed()
    {
        if (!$this->useSoftDeletes) {
            return [];
        }
        
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE {$this->deletedAtColumn} IS NOT NULL");
        return $stmt->fetchAll();
    }
    
    /**
     * Find records by specific field value
     * 
     * @param string $field
     * @param mixed $value
     * @return array
     */
    public function where($field, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE $field = :value";
        
        if ($this->useSoftDeletes) {
            $sql .= " AND {$this->deletedAtColumn} IS NULL";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll();
    }
    
    /**
     * Count all records in the table
     * 
     * @return int
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        
        if ($this->useSoftDeletes) {
            $sql .= " WHERE {$this->deletedAtColumn} IS NULL";
        }
        
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return (int) $result['count'];
    }

    /**
     * Sum the values of a specified column
     * 
     * @param string $column Column to sum
     * @param array $conditions Optional WHERE conditions as column => value pairs
     * @return float|int
     */
    public function sum($column, $conditions = [])
    {
        $sql = "SELECT SUM($column) as total FROM {$this->table}";
        
        $whereClause = $this->buildWhereClause($conditions);
        if ($whereClause) {
            $sql .= " WHERE $whereClause";
            
            if ($this->useSoftDeletes) {
                $sql .= " AND {$this->deletedAtColumn} IS NULL";
            }
        } elseif ($this->useSoftDeletes) {
            $sql .= " WHERE {$this->deletedAtColumn} IS NULL";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);
        $result = $stmt->fetch();
        return $result ? (float)$result['total'] : 0;
    }

    /**
     * Calculate the average of a specified column
     * 
     * @param string $column Column to average
     * @param array $conditions Optional WHERE conditions as column => value pairs
     * @return float|null
     */
    public function avg($column, $conditions = [])
    {
        $sql = "SELECT AVG($column) as average FROM {$this->table}";
        
        $whereClause = $this->buildWhereClause($conditions);
        if ($whereClause) {
            $sql .= " WHERE $whereClause";
            
            if ($this->useSoftDeletes) {
                $sql .= " AND {$this->deletedAtColumn} IS NULL";
            }
        } elseif ($this->useSoftDeletes) {
            $sql .= " WHERE {$this->deletedAtColumn} IS NULL";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);
        $result = $stmt->fetch();
        return $result ? (float)$result['average'] : null;
    }

    /**
     * Get the minimum value of a specified column
     * 
     * @param string $column Column to get minimum from
     * @param array $conditions Optional WHERE conditions as column => value pairs
     * @return mixed
     */
    public function min($column, $conditions = [])
    {
        $sql = "SELECT MIN($column) as minimum FROM {$this->table}";
        
        $whereClause = $this->buildWhereClause($conditions);
        if ($whereClause) {
            $sql .= " WHERE $whereClause";
            
            if ($this->useSoftDeletes) {
                $sql .= " AND {$this->deletedAtColumn} IS NULL";
            }
        } elseif ($this->useSoftDeletes) {
            $sql .= " WHERE {$this->deletedAtColumn} IS NULL";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);
        $result = $stmt->fetch();
        return $result ? $result['minimum'] : null;
    }

    /**
     * Get the maximum value of a specified column
     * 
     * @param string $column Column to get maximum from
     * @param array $conditions Optional WHERE conditions as column => value pairs
     * @return mixed
     */
    public function max($column, $conditions = [])
    {
        $sql = "SELECT MAX($column) as maximum FROM {$this->table}";
        
        $whereClause = $this->buildWhereClause($conditions);
        if ($whereClause) {
            $sql .= " WHERE $whereClause";
            
            if ($this->useSoftDeletes) {
                $sql .= " AND {$this->deletedAtColumn} IS NULL";
            }
        } elseif ($this->useSoftDeletes) {
            $sql .= " WHERE {$this->deletedAtColumn} IS NULL";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);
        $result = $stmt->fetch();
        return $result ? $result['maximum'] : null;
    }

    /**
     * Count distinct values in a column
     * 
     * @param string $column Column to count distinct values
     * @param array $conditions Optional WHERE conditions as column => value pairs
     * @return int
     */
    public function countDistinct($column, $conditions = [])
    {
        $sql = "SELECT COUNT(DISTINCT $column) as count FROM {$this->table}";
        
        $whereClause = $this->buildWhereClause($conditions);
        if ($whereClause) {
            $sql .= " WHERE $whereClause";
            
            if ($this->useSoftDeletes) {
                $sql .= " AND {$this->deletedAtColumn} IS NULL";
            }
        } elseif ($this->useSoftDeletes) {
            $sql .= " WHERE {$this->deletedAtColumn} IS NULL";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);
        $result = $stmt->fetch();
        return (int)$result['count'];
    }

    /**
     * Group results by a column and aggregate another column.
     * Supports optional WHERE, HAVING, and ORDER BY clauses.
     * 
     * @param string $groupColumn Column to group by
     * @param string $aggregateFunction Aggregate function to use (SUM, AVG, COUNT, etc.)
     * @param string $aggregateColumn Column to aggregate
     * @param array $conditions Optional WHERE conditions as column => value pairs
     * @param string|null $having Optional HAVING clause
     * @param array $havingParams Optional parameters for HAVING clause
     * @param string|null $orderBy Optional column to order results by
     * @param string $orderDir Sort direction: 'ASC' (default) or 'DESC'
     * @return array Grouped and aggregated result set
     */
    public function groupBy($groupColumn, $aggregateFunction, $aggregateColumn, $conditions = [], $having = null, $havingParams = [], $orderBy = null, $orderDir = 'ASC')
    {
        $sql = "SELECT $groupColumn, $aggregateFunction($aggregateColumn) as aggregate_value FROM {$this->table}";
        
        $whereClause = $this->buildWhereClause($conditions);
        if ($whereClause) {
            $sql .= " WHERE $whereClause";
            if ($this->useSoftDeletes) {
                $sql .= " AND {$this->deletedAtColumn} IS NULL";
            }
        } elseif ($this->useSoftDeletes) {
            $sql .= " WHERE {$this->deletedAtColumn} IS NULL";
        }

        $sql .= " GROUP BY $groupColumn";

        if ($having) {
            $sql .= " HAVING $having";
            $conditions = array_merge($conditions, $havingParams);
        }

        if ($orderBy) {
            $orderDir = strtoupper($orderDir) === 'DESC' ? 'DESC' : 'ASC';
            $sql .= " ORDER BY $orderBy $orderDir";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetchAll();
    }


    protected function buildWhereClause($conditions)
    {
        if (empty($conditions)) {
            return '';
        }
        
        $clauses = [];
        foreach (array_keys($conditions) as $column) {
            $clauses[] = "$column = :$column";
        }
        
        return implode(' AND ', $clauses);
    }
    
    /**
     * Get records with pagination
     * 
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function paginate($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$this->table}";
        
        if ($this->useSoftDeletes) {
            $sql .= " WHERE {$this->deletedAtColumn} IS NULL";
        }
        
        $sql .= " LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        
        $data = $stmt->fetchAll();
        
        $totalRecords = $this->count();
        $totalPages = ceil($totalRecords / $perPage);
        
        return [
            'data' => $data,
            'pagination' => [
                'total' => $totalRecords,
                'per_page' => $perPage,
                'current_page' => $page,
                'total_pages' => $totalPages,
                'has_more' => $page < $totalPages
            ]
        ];
    }
    
    /**
     * Execute a raw SQL query
     * 
     * @param string $query
     * @param array $params
     * @return array
     */
    public function rawQuery($query, $params = [])
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Begin a database transaction
     */
    public function beginTransaction()
    {
        $this->db->beginTransaction();
    }
    
    /**
     * Commit a database transaction
     */
    public function commit()
    {
        $this->db->commit();
    }
    
    /**
     * Rollback a database transaction
     */
    public function rollback()
    {
        $this->db->rollBack();
    }
    
    /**
     * Get the last inserted ID (PostgreSQL specific version)
     * 
     * @param string $sequence Optional sequence name
     * @return string
     */
    public function lastInsertId($sequence = null)
    {
        return $this->db->lastInsertId($sequence);
    }
    
    /**
     * Get only specified columns from all records
     * 
     * @param array $columns
     * @return array
     */
    public function select(array $columns)
    {
        $columns = implode(', ', $columns);
        
        $sql = "SELECT $columns FROM {$this->table}";
        
        if ($this->useSoftDeletes) {
            $sql .= " WHERE {$this->deletedAtColumn} IS NULL";
        }
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Join with another table
     * 
     * @param string $table Table to join with
     * @param string $firstKey First key for joining
     * @param string $secondKey Second key for joining
     * @param string $type Join type (INNER, LEFT, RIGHT)
     * @return array
     */
    public function join($table, $firstKey, $secondKey, $type = 'INNER')
    {
        $sql = "SELECT * FROM {$this->table} 
                $type JOIN $table ON {$this->table}.$firstKey = $table.$secondKey";
        
        if ($this->useSoftDeletes) {
            $sql .= " WHERE {$this->table}.{$this->deletedAtColumn} IS NULL";
        }
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Get records ordered by a specific column
     * 
     * @param string $column Column to order by
     * @param string $direction Direction (ASC or DESC)
     * @return array
     */
    public function orderBy($column, $direction = 'ASC')
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        
        $sql = "SELECT * FROM {$this->table}";
        
        if ($this->useSoftDeletes) {
            $sql .= " WHERE {$this->deletedAtColumn} IS NULL";
        }
        
        $sql .= " ORDER BY $column $direction";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Get records with a LIKE query
     * 
     * @param string $column Column to search in
     * @param string $search Search term
     * @return array
     */
    public function like($column, $search)
    {
        $sql = "SELECT * FROM {$this->table} WHERE $column ILIKE :search";
        
        if ($this->useSoftDeletes) {
            $sql .= " AND {$this->deletedAtColumn} IS NULL";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['search' => "%$search%"]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get first record matching a condition
     * 
     * @param string $field
     * @param mixed $value
     * @return array|null
     */
    public function firstWhere($field, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE $field = :value";
        
        if ($this->useSoftDeletes) {
            $sql .= " AND {$this->deletedAtColumn} IS NULL";
        }
        
        $sql .= " LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['value' => $value]);
        return $stmt->fetch() ?: null;
    }
}