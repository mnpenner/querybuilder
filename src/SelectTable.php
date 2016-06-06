<?php namespace QueryBuilder;

class SelectTable implements ITable {
    /** @var ISelect */
    protected $select;
    /** @var ITableAlias */
    protected $alias;

    function __construct(ISelect $select, ITableAlias $alias) {
        $this->select = $select;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return '('.$this->select->toSql($conn).') AS '.$this->alias->toSql($conn);
    }
}