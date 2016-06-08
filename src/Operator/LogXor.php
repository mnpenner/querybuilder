<?php namespace QueryBuilder\Operator;

use QueryBuilder\PolyadicOperator;

class LogXor extends PolyadicOperator {

    public function getOperator() {
        return 'XOR';
    }

    public function getPrecedence() {
        return 30;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}