<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractPolyadicOperator;

class LogicalOr extends AbstractPolyadicOperator {

    public function getOperator() {
        return 'OR';
    }

    public function getPrecedence() {
        return 20;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::ASSOCIATIVE;
    }
}