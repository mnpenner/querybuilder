<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractPolyadicOperator;

class NullSafeEquals extends AbstractPolyadicOperator {

    public function getOperator() {
        return '<=>';
    }

    public function getPrecedence() {
        return 70;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}