<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractPolyadicOperator;

class BitXor extends AbstractPolyadicOperator {
    public function getOperator() {
        return '^';
    }

    public function getPrecedence() {
        return 130;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}