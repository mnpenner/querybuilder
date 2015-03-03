<?php namespace QueryBuilder\Operator;

class RShift extends AbstractPolyadicOperator {

    public function getOperator() {
        return '>>';
    }

    public function getPrecedence() {
        return 8;
    }

    public function isAssociative() {
        return false;
    }
}