<?php namespace QueryBuilder\Operator;

class Mult extends AbstractPolyadicOperator {

    public function getOperator() {
        return '*';
    }

    public function getPrecedence() {
        return 120;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::ASSOCIATIVE;
    }
}