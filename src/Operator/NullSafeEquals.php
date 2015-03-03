<?php namespace QueryBuilder\Operator;

class NullSafeEquals extends AbstractPolyadicOperator {

    public function getOperator() {
        return '<=>';
    }

    public function getPrecedence() {
        return 11;
    }

    public function isAssociative() {
        return true;
    }
}