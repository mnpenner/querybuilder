<?php namespace QueryBuilder\Operator;

class BitwiseAnd extends AbstractNAryOperator {

    public function getOperator() {
        return '&';
    }

    public function getPrecedence() {
        return 9;
    }

    public function isAssociative() {
        return true;
    }
}