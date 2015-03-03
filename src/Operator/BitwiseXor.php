<?php namespace QueryBuilder\Operator;

class BitwiseXor extends AbstractUnaryOperator {
    public function getOperator() {
        return '^';
    }

    public function getPrecedence() {
        return 5;
    }
}