<?php namespace QueryBuilder\Operator;

class BitwiseOr extends AbstractPolyadicOperator {

    public function getOperator() {
        return '|';
    }

    public function getPrecedence() {
        return 10;
    }

    public function isAssociative() {
        return true;
    }
}