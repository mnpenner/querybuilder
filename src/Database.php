<?php namespace QueryBuilder;


class Database implements IDatabase {
    /** @var string */
    protected $name;

    /**
     * @param string $name
     */
    function __construct($name) {
        $this->name = $name;
    }

    public function toSql(ISqlConnection $conn) {
        return $conn->id($this->name);
    }

    public function table($tableName) {
        return new Table($tableName, $this);
    }
}