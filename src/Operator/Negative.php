<?php namespace QueryBuilder\Operator;

class Negative extends AbstractUnaryOperator {
    public function getOperator() {
        return '-';
    }

    public function getPrecedence() {
        return 140;
    }
}