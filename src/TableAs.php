<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\ITable;
use QueryBuilder\Interfaces\ITableAlias;
use QueryBuilder\Interfaces\ITableAs;

class TableAs implements ITableAs {
    /** @var ITable */
    protected $table;
    /** @var ITableAlias */
    protected $alias;

    function __construct(ITable $table, ITableAlias $alias) {
        $this->table = $table;
        $this->alias = $alias;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return $this->table->_toSql($conn, $ctx).' AS '.$this->getTableRef($conn, $ctx);
    }
    
    function getTableRef(ISqlConnection $conn, array &$ctx) {
        return $this->alias->_toSql($conn, $ctx);
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
}