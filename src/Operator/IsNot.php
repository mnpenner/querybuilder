<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractBinaryOperator;

class IsNot extends AbstractBinaryOperator {

    public function getOperator() {
        return 'IS NOT';
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