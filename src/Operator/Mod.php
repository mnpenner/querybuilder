<?php namespace QueryBuilder\Operator;
use QueryBuilder\AbstractPolyadicOperator;

/**
 * Modulo
 */
class Mod extends AbstractPolyadicOperator {

    public function getOperator() {
        return '%';
    }

    public function getPrecedence() {
        return 120;
    }
    
    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}