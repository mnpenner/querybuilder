<?php namespace QueryBuilder\Operator;
use QueryBuilder\AbstractPolyadicOperator;

/**
 * String concatenation.
 *
 * Assumes PIPES_AS_CONCAT is enabled.
 *
 * Not recommended for use.
 */
class Pipes extends AbstractPolyadicOperator {

    public function getOperator() {
        return '||';
    }

    public function getPrecedence() {
        return 20;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}