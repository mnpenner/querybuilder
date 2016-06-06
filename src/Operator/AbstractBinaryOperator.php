<?php namespace QueryBuilder\Operator;

use QueryBuilder\IExpr;
use QueryBuilder\IOperator;
use QueryBuilder\ISqlConnection;

abstract class AbstractBinaryOperator extends AbstractOperator implements IOperator {
    /** @var IExpr */
    protected $left;
    /** @var IExpr */
    protected $right;

    function __construct(IExpr $left, IExpr $right) {
        $this->left = $left;
        $this->right = $right;
    }

    public function toSql(ISqlConnection $conn) {
        $sql = '';
        if($this->left instanceof IOperator) {
            $sql .= $this->left->getSqlWrapped($conn, $this->left->getPrecedence() > $this->getPrecedence());
        } else {
            $sql .= $this->left->toSql($conn);
        }
        $sql .= ' '.$this->getOperator().' ';
        if($this->right instanceof IOperator) {
            $sql .= $this->right->getSqlWrapped($conn, $this->right->getPrecedence() > $this->getPrecedence());
        } else {
            $sql .= $this->right->toSql($conn);
        }

        return $sql;
    }
}