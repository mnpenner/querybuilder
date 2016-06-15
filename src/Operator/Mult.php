<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractPolyadicOperator;

class Mult extends AbstractPolyadicOperator {

    public function getOperator() {
        return '*';
    }

    public function getPrecedence() {
        return 120;
    }

    public function getAssociativity() {
        return Associativity::ASSOCIATIVE;
    }
}