<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractBinaryOperator;

class RegExp extends AbstractBinaryOperator {

    public function getOperator() {
        return 'REGEXP';
    }

    public function getPrecedence() {
        return 70;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}