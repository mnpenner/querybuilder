<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractPolyadicOperator;

class Equal extends AbstractPolyadicOperator {

    public function getOperator() {
        return '=';
    }

    public function getPrecedence() {
        return 70;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}