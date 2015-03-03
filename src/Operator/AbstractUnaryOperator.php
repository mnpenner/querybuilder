<?php namespace QueryBuilder\Operator;

use QueryBuilder\IExpr;
use QueryBuilder\IOperator;
use QueryBuilder\ISqlConnection;

abstract class AbstractUnaryOperator implements IOperator {
    /** @var IExpr */
    protected $expr;

    function __construct(IExpr $expr) {
        $this->expr = $expr;
    }

    public function operandCount() {
        return 1;
    }

    public function toSql(ISqlConnection $conn) {
        $op = $this->getOperator();
        return $op . (strlen($op) > 1 ? ' ' : '').$this->expr->toSql($conn);
    }
}