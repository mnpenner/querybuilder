<?php namespace QueryBuilder\Operator;

class LTE extends AbstractNAryOperator {

    public function getOperator() {
        return '<=';
    }

    public function getPrecedence() {
        return 11;
    }

    public function isAssociative() {
        return true;
    }
}