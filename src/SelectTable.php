<?php namespace QueryBuilder;

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

    public function toSql(ISqlConnection $conn) {
        return '('.$this->select->toSql($conn).') AS '.$this->alias->toSql($conn);
    }
}