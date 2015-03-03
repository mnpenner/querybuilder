<?php namespace QueryBuilder\Operator;

class LessThan extends AbstractNAryOperator {

    public function getOperator() {
        return '<';
    }

    public function getPrecedence() {
        return 11;
    }

    public function isAssociative() {
        return true;
    }
}