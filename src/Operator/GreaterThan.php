<?php namespace QueryBuilder\Operator;

class GreaterThan extends AbstractPolyadicOperator {

    public function getOperator() {
        return '>';
    }

    public function getPrecedence() {
        return 11;
    }

    public function isAssociative() {
        return false;
    }
}