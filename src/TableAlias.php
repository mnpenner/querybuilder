<?php namespace QueryBuilder;

class TableAlias implements ITableRef {
    /** @var TableRef */
    protected $identifier;
    /** @var string */
    protected $alias;

    function __construct(TableRef $identifier, $alias) {
        $this->identifier = $identifier;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->identifier->toSql($conn).' AS '.$conn->id($this->alias);
    }
}