<?php namespace QueryBuilder\Operator;

use QueryBuilder\PolyadicOperator;

class LessThan extends PolyadicOperator { // Although it is weird, "SELECT 1 < 2 < 3" is valid SQL

    public function getOperator() {
        return '<';
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