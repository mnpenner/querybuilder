<?php namespace QueryBuilder\Operator;

class Add extends AbstractPolyadicOperator {

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