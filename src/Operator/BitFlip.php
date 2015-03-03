<?php namespace QueryBuilder\Operator;

class BitFlip extends AbstractUnaryOperator {
    public function getOperator() {
        return '~';
    }

    public function getPrecedence() {
        return 3;
    }
}