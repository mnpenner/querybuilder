<?php namespace QueryBuilder;

/**
 * Represents an (optionally) fully-qualified column name.
 */
class Column implements IColumn {
    /** @var string */
    protected $column;
    /** @var IAliasOrTable */
    protected $table;

    /**
     * @param string $column Table name
     * @param IAliasOrTable|null $table Database name
     */
    function __construct($column, IAliasOrTable $table=null) {
        $this->column = $column;
        $this->table = $table;
    }

    public function toSql(ISqlConnection $conn) {
        return ($this->table ? $this->table->toSql($conn) . '.' : '') . $conn->id($this->column);
    }
}