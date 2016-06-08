<?php namespace QueryBuilder\Operator;

use QueryBuilder\PolyadicOperator;
use QueryBuilder\Interfaces\IExprOrInterval;

class Sub extends PolyadicOperator {

    function __construct(IExprOrInterval ...$operands) {
        parent::__construct(...$operands);
    }

    public function getOperator() {
        return '-';
    }

    public function getPrecedence() {
        return 110;
    }

    public function isAssociative() {
        return false;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}