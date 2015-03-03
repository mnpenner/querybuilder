<?php namespace QueryBuilder\Operator;

class Like extends AbstractNAryOperator {

    public function getOperator() {
        return 'LIKE';
    }

    public function getPrecedence() {
        return 11;
    }

    public function isAssociative() {
        return true;
    }
}