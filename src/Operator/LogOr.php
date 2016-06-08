<?php namespace QueryBuilder\Operator;

use QueryBuilder\PolyadicOperator;

class LogOr extends PolyadicOperator {

    public function getOperator() {
        return 'OR';
    }

    public function getPrecedence() {
        return 20;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::ASSOCIATIVE;
    }
}