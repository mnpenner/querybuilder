<?php namespace QueryBuilder\Operator;

class LogicalOr extends AbstractPolyadicOperator {

    public function getOperator() {
        return 'OR';
    }

    public function getPrecedence() {
        return 16;
    }

    public function isAssociative() {
        return true;
    }
}