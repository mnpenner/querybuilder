<?php namespace QueryBuilder\Operator;

class LogOr extends AbstractPolyadicOperator {

    public function getOperator() {
        return 'OR';
    }

    public function getPrecedence() {
        return 20;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::ASSOCIATIVE;
    }
}