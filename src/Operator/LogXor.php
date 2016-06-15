<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractPolyadicOperator;

class LogXor extends AbstractPolyadicOperator {

    public function getOperator() {
        return 'XOR';
    }

    public function getPrecedence() {
        return 30;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}