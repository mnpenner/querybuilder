<?php namespace QueryBuilder\Operator;

/**
 * Modulo
 */
class Mod extends AbstractPolyadicOperator {

    public function getOperator() {
        return '%';
    }

    public function getPrecedence() {
        return 6;
    }

    public function isAssociative() {
        return true;
    }
}