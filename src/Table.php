<?php namespace QueryBuilder;

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

    public function toSql(ISqlConnection $conn) {
        return ($this->database ? $this->database->toSql($conn) . '.' : '') . $conn->id($this->table);
    }
}