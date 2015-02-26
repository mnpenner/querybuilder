<?php namespace QueryBuilder;

class SubQueryAlias implements ITable {
    /** @var SubQuery */
    protected $subQuery;
    /** @var string */
    protected $alias;

    function __construct(SubQuery $subQuery, $alias) {
        $this->subQuery = $subQuery;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->subQuery->toSql($conn).' AS '.$conn->id($this->alias);
    }
}