<?php namespace QueryBuilder\Operator;
use QueryBuilder\AbstractPolyadicOperator;

/**
 * Integer division.
 */
class IntDiv extends AbstractPolyadicOperator {

    public function getOperator() {
        return 'DIV';
    }

    public function getPrecedence() {
        return 120;
    }
    
    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}