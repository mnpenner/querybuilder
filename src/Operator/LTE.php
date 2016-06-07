<?php namespace QueryBuilder\Operator;

class LTE extends AbstractPolyadicOperator {

    public function getOperator() {
        return '<=';
    }

    public function getPrecedence() {
        return 70;
    }

    public function isAssociative() {
        return false;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}