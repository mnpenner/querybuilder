<?php namespace QueryBuilder\Operator;

class RegExp extends AbstractNAryOperator {

    public function getOperator() {
        return 'REGEXP';
    }

    public function getPrecedence() {
        return 11;
    }

    public function isAssociative() {
        return true;
    }
}