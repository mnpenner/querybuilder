<?php namespace QueryBuilder\Operator;

class Not extends AbstractUnaryOperator {
    public function getOperator() {
        return 'NOT';
    }

    public function getPrecedence() {
        return 13;
    }
}