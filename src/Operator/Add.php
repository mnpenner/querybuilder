<?php namespace QueryBuilder\Operator;

class Add extends AbstractNAryOperator {

    public function getOperator() {
        return '+';
    }

    public function getPrecedence() {
        return 7;
    }

    public function isAssociative() {
        return true;
    }
}