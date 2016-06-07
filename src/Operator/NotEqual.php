<?php namespace QueryBuilder\Operator;

class NotEqual extends AbstractPolyadicOperator {

    public function getOperator() {
        return '!='; // aka <>
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