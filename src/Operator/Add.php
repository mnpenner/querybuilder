<?php namespace QueryBuilder\Operator;

use QueryBuilder\PolyadicOperator;
use QueryBuilder\Interfaces\IExprOrInterval;

class Add extends PolyadicOperator {

    function __construct(IExprOrInterval ...$operands) {
        parent::__construct(...$operands);
    }

    public function getOperator() {
        return '+';
    }

    public function getPrecedence() {
        return 110;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::ASSOCIATIVE;
    }
}