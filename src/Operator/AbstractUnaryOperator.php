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

    public function toSql(ISqlConnection $conn, $needs_parens=false) {
        $op = $this->getOperator();
        $sql = $op;
        if(strlen($op) > 1) $sql .= ' ';

        if($this->expr instanceof IOperator) {
            $sql .= $this->expr->toSql($conn, $this->expr->getPrecedence() > $this->getPrecedence());
        } else {
            $sql .= $this->expr->toSql($conn);
        }

        return $needs_parens ? "($sql)" : $sql;
    }
}