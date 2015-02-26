<?php namespace QueryBuilder;

/**
 * Represents an (optionally) fully-qualified table name.
 */
class Table implements ITable {
    /** @var string */
    protected $databaseName;
    /** @var string */
    protected $tableName;

    /**
     * @param string $database Database name, or table name if 2nd arg is omitted
     * @param string $table Table name
     */
    function __construct($database, $table=null) {
        switch(func_num_args()) {
            case 1:
                $this->databaseName = null;
                $this->tableName = $database;
                break;
            case 2:
                $this->databaseName = $database;
                $this->tableName = $table;
                break;
            default:
                throw new \BadMethodCallException("Expected 1 or 2 args");
        }
    }

    public function toSql(ISqlConnection $conn) {
        $parts = [];
        if(strlen($this->databaseName)) $parts[] = $conn->id($this->databaseName);
        $parts[] = $conn->id($this->tableName);
        return implode('.', $parts);
    }
}