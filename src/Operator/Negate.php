<?php namespace QueryBuilder\Operator;

/**
 * Logical NOT.
 */
class Negate extends AbstractUnaryOperator {
    public function getOperator() {
        return '!';
    }

    public function getPrecedence() {
        return 150;
    }
}