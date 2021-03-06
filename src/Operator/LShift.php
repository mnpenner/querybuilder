<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractPolyadicOperator;

class LShift extends AbstractPolyadicOperator {

    public function getOperator() {
        return '<<';
    }

    public function getPrecedence() {
        return 100;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}