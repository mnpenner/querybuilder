<?php namespace QueryBuilder\Operator;

class RShift extends AbstractPolyadicOperator {

    public function getOperator() {
        return '>>';
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