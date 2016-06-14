<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractPolyadicOperator;

class BitOr extends AbstractPolyadicOperator {

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