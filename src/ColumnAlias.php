<?php namespace QueryBuilder;

class ColumnAlias implements IField {
    /** @var IExpr */
    protected $identifier;
    /** @var string */
    protected $alias;

    function __construct(IExpr $identifier, $alias) {
        $this->identifier = $identifier;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->identifier->toSql($conn).' AS '.$conn->id($this->alias);
    }
}