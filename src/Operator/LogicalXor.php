<?php namespace QueryBuilder\Operator;

class LogicalXor extends AbstractPolyadicOperator {

    public function getOperator() {
        return 'XOR';
    }

    public function getPrecedence() {
        return 15;
    }

    public function isAssociative() {
        return true;
    }
}