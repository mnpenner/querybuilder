<?php namespace QueryBuilder\Operator;

class BitAnd extends AbstractPolyadicOperator {

    public function getOperator() {
        return '&';
    }

    public function getPrecedence() {
        return 90;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}