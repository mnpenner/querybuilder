<?php namespace QueryBuilder\Operator;

use QueryBuilder\IExpr;
use QueryBuilder\IOperator;
use QueryBuilder\ISqlConnection;

class Between extends AbstractOperator {
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
        return false; // select 4 between (2 between 1 and 3) and 5
    }

    public function operandCount() {
        return 3;
    }

    public function toSql(ISqlConnection $conn) {
        $lowSql = $this->low instanceof IOperator ? $this->low->getSqlWrapped($conn, true) : $this->low->toSql($conn);
        $highSql = $this->high instanceof IOperator ? $this->high->getSqlWrapped($conn, true) : $this->high->toSql($conn);
        return $this->value->toSql($conn)." BETWEEN $lowSql AND $highSql";
    }
}