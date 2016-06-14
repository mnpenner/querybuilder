<?php namespace QueryBuilder;

use QueryBuilder\AbstractOperator;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IOperator;
use QueryBuilder\Interfaces\ISqlConnection;

abstract class UnaryOperator extends AbstractOperator implements IOperator {
    /** @var IExpr */
    protected $expr;

    function __construct(IExpr $expr) {
        $this->expr = $expr;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        $op = $this->getOperator();
        $sql = $op;
        if(strlen($op) > 1) $sql .= ' ';

        if($this->expr instanceof IOperator) {
            $sql .= $this->expr->getSqlWrapped($conn, $this->expr->getPrecedence() < $this->getPrecedence(),$ctx);
        } else {
            $sql .= $this->expr->_toSql($conn, $ctx);
        }

        return $sql;
    }
}