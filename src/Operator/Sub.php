<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractPolyadicOperator;
use QueryBuilder\Interfaces\IExprOrInterval;

class Sub extends AbstractPolyadicOperator {

    function __construct(IExprOrInterval ...$operands) {
        parent::__construct(...$operands);
    }

    public function getOperator() {
        return '-';
    }

    public function getPrecedence() {
        return 110;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}