<?php namespace QueryBuilder\Operator;

class LogicalOr extends AbstractNAryOperator {

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