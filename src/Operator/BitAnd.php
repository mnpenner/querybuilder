<?php namespace QueryBuilder\Operator;

use QueryBuilder\PolyadicOperator;

class BitAnd extends PolyadicOperator {

    public function getOperator() {
        return '&';
    }

    public function getPrecedence() {
        return 90;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}