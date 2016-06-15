<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractBinaryOperator;

class NotIn extends In {
    public function getOperator() {
        return 'NOT IN';
    }
}