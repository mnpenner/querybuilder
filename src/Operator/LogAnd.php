<?php namespace QueryBuilder\Operator;

class LogAnd extends AbstractPolyadicOperator {

    public function getOperator() {
        return 'AND';
    }

    public function getPrecedence() {
        return 40;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::ASSOCIATIVE;
    }
}