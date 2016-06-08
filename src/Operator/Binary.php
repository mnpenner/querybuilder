<?php namespace QueryBuilder\Operator;

use QueryBuilder\UnaryOperator;

class Binary extends UnaryOperator {
    public function getOperator() {
        return 'BINARY';
    }

    public function getPrecedence() {
        return 160;
    }
}