<?php namespace QueryBuilder\Operator;

class LogicalAnd extends AbstractNAryOperator {

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