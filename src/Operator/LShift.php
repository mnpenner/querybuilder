<?php namespace QueryBuilder\Operator;

class LShift extends AbstractNAryOperator {

    public function getOperator() {
        return '<<';
    }

    public function getPrecedence() {
        return 8;
    }

    public function isAssociative() {
        return false;
    }
}