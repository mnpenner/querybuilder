<?php namespace QueryBuilder\Operator;

class LShift extends AbstractPolyadicOperator {

    public function getOperator() {
        return '<<';
    }

    public function getPrecedence() {
        return 100;
    }

    public function isAssociative() {
        return false;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}