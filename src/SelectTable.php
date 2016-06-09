<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\ISelect;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\ITable;
use QueryBuilder\Interfaces\ITableAlias;

class SelectTable implements ITable {
    /** @var ISelect */
    protected $select;
    /** @var ITableAlias */
    protected $alias;

    /**
     * @param ISelect $select Select statement
     * @param ITableAlias $alias Every derived table must have its own alias
     */
    function __construct(ISelect $select, ITableAlias $alias) { // TODO: allow null and generate a random string??
        $this->select = $select;
        $this->alias = $alias;
    }

    public function _toSql(ISqlConnection $conn, \QueryBuilder\Interfaces\IDict $ctx) {
        return '('.$this->select->_toSql($conn, $ctx).') AS '.$this->alias->_toSql($conn, $ctx);
    }
}