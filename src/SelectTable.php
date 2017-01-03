<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\ISelect;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\ITable;
use QueryBuilder\Interfaces\ITableAlias;

/***
 * Represents a temporary/in-memory table; i.e., a SELECT clause wrapped in parens with an alias: (SELECT ... FROM ...) AS `t`
 */
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

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return '('.$this->select->_toSql($conn, $ctx).') AS '.$this->getTableRef($conn, $ctx);
    }
    
    function getTableRef(ISqlConnection $conn, array &$ctx) {
        return $this->alias->_toSql($conn, $ctx);
    }
    
    function getTableName() {
        throw new \Exception("Temporary table does not have a name"); // FIXME: Maybe this shouldn't implement ITable then...?
    }
}