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
        $parts = [];
        if($this->database) $parts[] = $this->database->toSql($conn);
        $parts[] = $conn->id($this->table);
        return implode('.', $parts);
    }
}