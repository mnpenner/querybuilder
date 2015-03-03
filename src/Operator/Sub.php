<?php namespace QueryBuilder\Operator;

class Sub extends AbstractPolyadicOperator {

    public function getOperator() {
        return '-';
    }

    public function getPrecedence() {
        return 7;
    }

    public function isAssociative() {
        return false;
    }
}