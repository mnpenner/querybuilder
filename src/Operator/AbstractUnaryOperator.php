<?php namespace QueryBuilder\Operator;

use QueryBuilder\IExpr;
use QueryBuilder\IOperator;
use QueryBuilder\ISqlConnection;

abstract class AbstractUnaryOperator extends AbstractOperator implements IOperator {
    /** @var IExpr */
    protected $expr;

    function __construct(IExpr $expr) {
        $this->expr = $expr;
    }

    public function toSql(ISqlConnection $conn) {
        $op = $this->getOperator();
        $sql = $op;
        if(strlen($op) > 1) $sql .= ' ';

        if($this->expr instanceof IOperator) {
            $sql .= $this->expr->getSqlWrapped($conn, $this->expr->getPrecedence() < $this->getPrecedence());
        } else {
            $sql .= $this->expr->toSql($conn);
        }

        return $sql;
    }
}