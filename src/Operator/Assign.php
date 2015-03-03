<?php namespace QueryBuilder\Operator;

use QueryBuilder\IExpr;
use QueryBuilder\IVar;

class Assign extends AbstractPolyadicOperator {
    function __construct(IVar $name, IExpr $value) {
        $this->operands = [$name, $value];
    }

    public function getOperator() {
        return ':=';
    }

    public function getPrecedence() {
        return 17;
    }

    public function isAssociative() {
        return true; // @x := 1 := 2 is a syntax error
    }
}