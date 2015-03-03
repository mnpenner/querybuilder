<?php namespace QueryBuilder\Operator;

class Assign extends AbstractNAryOperator {

    public function getOperator() {
        return ':=';
    }

    public function getPrecedence() {
        return 17;
    }

    public function isAssociative() {
        return true;
    }
}