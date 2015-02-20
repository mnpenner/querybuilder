<?php namespace QueryBuilder;

class ColumnAlias implements ISelectExpr {
    /** @var ColumnSpec */
    protected $identifier;
    /** @var string */
    protected $alias;

    function __construct(ColumnSpec $identifier, $alias) {
        $this->identifier = $identifier;
        $this->alias = $alias;
    }

    public function toSql(SqlConnection $conn) {
        return $this->identifier->toSql($conn).' AS '.$conn->id($this->alias);
    }
}