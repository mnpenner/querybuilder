<?php namespace QueryBuilder\Operator;

class Is extends AbstractPolyadicOperator {

    public function getOperator() {
        return 'IS';
    }

    public function getPrecedence() {
        return 11;
    }

    public function isAssociative() {
        return true;
    }
}