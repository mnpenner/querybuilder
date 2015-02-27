<?php namespace QueryBuilder;

class SubQueryTable implements ITable {
    /** @var ISelect */
    protected $select;
    /** @var IAlias */
    protected $alias;

    function __construct(ISelect $select, IAlias $alias) {
        $this->select = $select;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return '('.$this->select->toSql($conn).') AS '.$this->alias->toSql($conn);
    }
}