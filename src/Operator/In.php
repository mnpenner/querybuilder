<?php namespace QueryBuilder\Operator;

class In extends AbstractNAryOperator {

    public function getOperator() {
        return 'IN';
    }

    public function getPrecedence() {
        return 11;
    }

    public function isAssociative() {
        return true;
    }
}