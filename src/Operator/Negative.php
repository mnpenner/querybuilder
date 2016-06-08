<?php namespace QueryBuilder\Operator;

use QueryBuilder\UnaryOperator;

class Negative extends UnaryOperator {
    public function getOperator() {
        return '-';
    }

    public function getPrecedence() {
        return 140;
    }
}