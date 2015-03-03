<?php namespace QueryBuilder\Operator;

class BitwiseOr extends AbstractNAryOperator {

    public function getOperator() {
        return '|';
    }

    public function getPrecedence() {
        return 10;
    }

    public function isAssociative() {
        return true;
    }
}