<?php namespace QueryBuilder;

use QueryBuilder\Operator;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IOperator;
use QueryBuilder\Interfaces\ISqlConnection;

abstract class UnaryOperator extends Operator implements IOperator {
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