<?php namespace QueryBuilder\Operator;

use QueryBuilder\IExpr;
use QueryBuilder\IOperator;
use QueryBuilder\ISqlConnection;

class Between implements IOperator {
    /** @var IExpr */
    protected $value;
    /** @var IExpr */
    protected $low;
    /** @var IExpr */
    protected $high;

    function __construct(IExpr $value, IExpr $low, IExpr $high) {
        $this->value = $value;
        $this->low = $low;
        $this->high = $high;
    }

    public function getOperator() {
        return 'BETWEEN';
    }

    public function getPrecedence() {
        return 12;
    }

    public function isAssociative() {
        return true;
    }

    public function operandCount() {
        return 3;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->value->toSql($conn).' BETWEEN '.$this->low->toSql($conn).' AND '.$this->high->toSql($conn);
    }
}