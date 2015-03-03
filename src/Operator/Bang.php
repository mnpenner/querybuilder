<?php namespace QueryBuilder\Operator;

/**
 * Logical NOT.
 *
 * Assumes HIGH_NOT_PRECEDENCE is *not* enabled.
 *
 * Not recommended for use.
 */
class Bang extends AbstractUnaryOperator {
    public function getOperator() {
        return '!';
    }

    public function getPrecedence() {
        return 2;
    }
}