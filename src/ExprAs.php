<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IField;
use QueryBuilder\Interfaces\IFieldAlias;
use QueryBuilder\Interfaces\ISqlConnection;

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