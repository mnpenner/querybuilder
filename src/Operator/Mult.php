<?php namespace QueryBuilder\Operator;

use QueryBuilder\PolyadicOperator;

class Mult extends PolyadicOperator {

    public function getOperator() {
        return '*';
    }

    public function getPrecedence() {
        return 120;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::ASSOCIATIVE;
    }
}