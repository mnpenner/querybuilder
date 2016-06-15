<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractPolyadicOperator;

class BitAnd extends AbstractPolyadicOperator {

    public function getOperator() {
        return '&';
    }

    public function getPrecedence() {
        return 90;
    }
    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}