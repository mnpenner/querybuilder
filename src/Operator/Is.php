<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractBinaryOperator;

class Is extends AbstractBinaryOperator {

    public function getOperator() {
        return 'IS';
    }

    public function getPrecedence() {
        return 70;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}