<?php namespace QueryBuilder\Operator;

use QueryBuilder\UnaryOperator;

class BitXor extends UnaryOperator {
    public function getOperator() {
        return '^';
    }

    public function getPrecedence() {
        return 130;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}