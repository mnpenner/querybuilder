<?php namespace QueryBuilder\Operator;
use QueryBuilder\PolyadicOperator;

/**
 * Modulo
 */
class Mod extends PolyadicOperator {

    public function getOperator() {
        return '%';
    }

    public function getPrecedence() {
        return 120;
    }

    public function isAssociative() {
        return false;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}