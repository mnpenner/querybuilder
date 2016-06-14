<?php namespace QueryBuilder\Operator;

use QueryBuilder\AbstractBinaryOperator;

class In extends AbstractBinaryOperator {

    public function getOperator() {
        return 'IN';
    }

    public function getPrecedence() {
        return 70;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}