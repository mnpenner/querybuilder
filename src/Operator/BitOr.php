<?php namespace QueryBuilder\Operator;

use QueryBuilder\PolyadicOperator;

class BitOr extends PolyadicOperator {

    public function getOperator() {
        return '|';
    }

    public function getPrecedence() {
        return 80;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}