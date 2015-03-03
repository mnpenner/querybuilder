<?php namespace QueryBuilder\Operator;

/**
 * Integer division.
 */
class IntDiv extends AbstractPolyadicOperator {

    public function getOperator() {
        return 'DIV';
    }

    public function getPrecedence() {
        return 6;
    }

    public function isAssociative() {
        return true;
    }
}