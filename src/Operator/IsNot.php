<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractBinaryOperator;

class IsNot extends Is {
    public function getOperator() {
        return 'IS NOT';
    }
}