<?php namespace QueryBuilder\Operator;

/**
 * Integer division.
 */
class IntDiv extends AbstractPolyadicOperator {

    public function getOperator() {
        return 'DIV';
    }

    public function getPrecedence() {
        return 120;
    }

    public function isAssociative() {
        return false;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}