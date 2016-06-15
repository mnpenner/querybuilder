<?php namespace QueryBuilder\Operator;
use QueryBuilder\AbstractPolyadicOperator;

/**
 * Division.
 */
class Div extends AbstractPolyadicOperator {

    public function getOperator() {
        return '/';
    }

    public function getPrecedence() {
        return 120;
    }
    
    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}