<?php namespace QueryBuilder\Operator;
use QueryBuilder\UnaryOperator;

/**
 * Logical NOT.
 */
class Negate extends UnaryOperator {
    public function getOperator() {
        return '!';
    }

    public function getPrecedence() {
        return 150;
    }
}