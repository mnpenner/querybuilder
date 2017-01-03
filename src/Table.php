<?php namespace QueryBuilder;
use QueryBuilder\Interfaces\IDatabase;
use QueryBuilder\Interfaces\IField;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\ITable;

/**
 * Represents an (optionally) fully-qualified table name.
 */
class Table implements ITable {
    /** @var string */
    protected $table;
    /** @var IDatabase */
    protected $database;


    /**
     * @param string $table Table name
     * @param IDatabase|null $database Database name
     */
    function __construct($table, IDatabase $database=null) {
        $this->table = $table;
        $this->database = $database;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return $this->getTableRef($conn, $ctx);
    }

    public function getTableName() {
        return $this->table;
    }

    /**
     * Convenience method. Returns a new column, qualified as belonging to this table.
     * 
     * @param string $columnName
     * @return Column
     */
    public function column($columnName) {
        return new Column($columnName, $this);
    }
    
    function getTableRef(ISqlConnection $conn, array &$ctx) {
        return ($this->database ? $this->database->_toSql($conn, $ctx) . '.' : '') . $conn->id($this->table, $ctx);
    }
}