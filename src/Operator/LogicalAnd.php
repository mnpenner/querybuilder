<?php namespace QueryBuilder\Operator;

class LogicalAnd extends AbstractPolyadicOperator {

    public function getOperator() {
        return 'AND';
    }

    public function getPrecedence() {
        return 14;
    }

    public function isAssociative() {
        return true;
    }
}