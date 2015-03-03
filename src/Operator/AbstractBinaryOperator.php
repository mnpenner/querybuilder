<?php namespace QueryBuilder\Operator;

use QueryBuilder\IExpr;
use QueryBuilder\IOperator;
use QueryBuilder\ISqlConnection;

abstract class AbstractBinaryOperator implements IOperator {
    /** @var IExpr */
    protected $lhs;
    /** @var IExpr */
    protected $rhs;

    function __construct(IExpr $lhs, IExpr $rhs) {
        $this->lhs = $lhs;
        $this->rhs = $rhs;
    }

    public function operandCount() {
        return 2;
    }

    public function toSql(ISqlConnection $conn) {
        $op = $this->getOperator();
        return $this->lhs->toSql($conn) . (strlen($op) > 1 ? " $op " : $op) . $this->rhs->toSql($conn);
    }
}