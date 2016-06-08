<?php namespace QueryBuilder\Operator;

use QueryBuilder\BinaryOperator;

class RegExp extends BinaryOperator {

    public function getOperator() {
        return 'REGEXP';
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