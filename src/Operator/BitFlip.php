<?php namespace QueryBuilder\Operator;

use QueryBuilder\UnaryOperator;

class BitFlip extends UnaryOperator {
    public function getOperator() {
        return '~';
    }

    public function getPrecedence() {
        return 140;
    }
}