<?php namespace QueryBuilder;

class ExprAs implements IField {
    /** @var IExpr */
    protected $expr;
    /** @var IFieldAlias */
    protected $alias;

    function __construct(IExpr $expr, IFieldAlias $alias) {
        $this->expr = $expr;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->expr->toSql($conn).' AS '.$this->alias->toSql($conn);
    }
}