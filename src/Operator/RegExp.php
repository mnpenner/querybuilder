<?php namespace QueryBuilder\Operator;

class RegExp extends AbstractBinaryOperator {

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