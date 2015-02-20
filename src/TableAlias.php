<?php namespace QueryBuilder;

class TableAlias implements ITableRef {
    /** @var TableSpec */
    protected $identifier;
    /** @var string */
    protected $alias;

    function __construct(TableSpec $identifier, $alias) {
        $this->identifier = $identifier;
        $this->alias = $alias;
    }

    public function toSql(SqlConnection $conn) {
        return $this->identifier->toSql($conn).' AS '.$conn->id($this->alias);
    }
}