<?php namespace QueryBuilder;


use QueryBuilder\Interfaces\IDatabase;
use QueryBuilder\Interfaces\ISqlConnection;

class Database implements IDatabase {
    /** @var string */
    protected $name;

    /**
     * @param string $name
     */
    function __construct($name) {
        $this->name = $name;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return $conn->id($this->name, $ctx);
    }

    /**
     * @param string $tableName
     * @return Table
     */
    public function table($tableName) {
        return new Table($tableName, $this);
    }
}