<?php namespace QueryBuilder\Operator;

/**
 * String concatenation.
 *
 * Assumes PIPES_AS_CONCAT is enabled.
 *
 * Not recommended for use.
 */
class Pipes extends AbstractNAryOperator {

    public function getOperator() {
        return '||';
    }

    public function getPrecedence() {
        return 4;
    }

    public function isAssociative() {
        return true;
    }
}