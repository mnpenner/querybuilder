<?php namespace QueryBuilder\Operator;

class Is extends AbstractBinaryOperator {

    public function getOperator() {
        return 'IS';
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