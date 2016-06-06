<?php namespace QueryBuilder\Operator;

class LessThan extends AbstractPolyadicOperator { // Although it is weird, "SELECT 1 < 2 < 3" is valid SQL

    public function getOperator() {
        return '<';
    }

    public function getPrecedence() {
        return 11;
    }

    public function isAssociative() {
        return false;
    }
}