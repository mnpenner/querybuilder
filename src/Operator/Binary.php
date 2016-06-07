<?php namespace QueryBuilder\Operator;

class Binary extends AbstractUnaryOperator {
    public function getOperator() {
        return 'BINARY';
    }

    public function getPrecedence() {
        return 160;
    }
}