<?php namespace QueryBuilder\Operator;

use QueryBuilder\PolyadicOperator;

class LogAnd extends PolyadicOperator {

    public function getOperator() {
        return 'AND';
    }

    public function getPrecedence() {
        return 40;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::ASSOCIATIVE;
    }
}