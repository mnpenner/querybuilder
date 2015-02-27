<?php namespace QueryBuilder;

class SubQueryAlias implements ITable {
    /** @var ISelect */
    protected $select;
    /** @var string */
    protected $alias;

    function __construct(ISelect $select, $alias) {
        $this->select = $select;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return '('.$this->select->toSql($conn).') AS '.$conn->id($this->alias);
    }
}