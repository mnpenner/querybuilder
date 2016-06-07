<?php namespace QueryBuilder\Operator;

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

    public function isAssociative() {
        return false;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}