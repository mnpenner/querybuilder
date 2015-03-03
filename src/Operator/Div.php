<?php namespace QueryBuilder\Operator;

/**
 * Division.
 */
class Div extends AbstractNAryOperator {

    public function getOperator() {
        return '/';
    }

    public function getPrecedence() {
        return 6;
    }

    public function isAssociative() {
        return true;
    }
}