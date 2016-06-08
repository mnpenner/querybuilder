<?php namespace QueryBuilder\Operator;

use QueryBuilder\PolyadicOperator;

class Equal extends PolyadicOperator {

    public function getOperator() {
        return '=';
    }

    public function getPrecedence() {
        return 70;
    }

    public function isAssociative() {
        return false;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}