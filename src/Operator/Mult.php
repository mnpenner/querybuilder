<?php namespace QueryBuilder\Operator;

class Mult extends AbstractPolyadicOperator {

    public function getOperator() {
        return '*';
    }

    public function getPrecedence() {
        return 6;
    }

    public function isAssociative() {
        return true;
    }
}