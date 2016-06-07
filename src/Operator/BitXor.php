<?php namespace QueryBuilder\Operator;

class BitXor extends AbstractUnaryOperator {
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