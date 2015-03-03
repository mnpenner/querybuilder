<?php namespace QueryBuilder\Operator;

class Sub extends AbstractNAryOperator {

    public function getOperator() {
        return '-';
    }

    public function getPrecedence() {
        return 7;
    }

    public function isAssociative() {
        return true;
    }
}