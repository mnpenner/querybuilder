<?php namespace QueryBuilder\Operator;

class GTE extends AbstractPolyadicOperator {

    public function getOperator() {
        return '>=';
    }

    public function getPrecedence() {
        return 11;
    }

    public function isAssociative() {
        return false;
    }
}