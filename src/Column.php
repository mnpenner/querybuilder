<?php namespace QueryBuilder;
use QueryBuilder\Interfaces\IColumn;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\ITableOrTableAlias;

/**
 * Represents an (optionally) fully-qualified column name.
 */
class Column implements IColumn {
    /** @var string */
    protected $column;
    /** @var ITableOrTableAlias */
    protected $table;

    /**
     * @param string $column Column name
     * @param ITableOrTableAlias|null $table Table name
     */
    function __construct($column, ITableOrTableAlias $table=null) {
        $this->column = $column;
        $this->table = $table;
    }

    public function _toSql(ISqlConnection $conn, \QueryBuilder\Interfaces\IDict $ctx) {
        return ($this->table ? $this->table->_toSql($conn, $ctx) . '.' : '') . $conn->id($this->column, $ctx);
    }
}