<?php namespace QueryBuilder\Operator;

use QueryBuilder\PolyadicOperator;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IVar;

class Assign extends PolyadicOperator {
    function __construct(IVar $name, IExpr $value) {
        parent::__construct($name, $value);
    }

    public function getOperator() {
        return ':=';
    }

    public function getPrecedence() {
        return 10;
    }

    public function isAssociative() {
        return true; // @x := 1 := 2 is a syntax error
    }

    public function getAssociativity() {
        return Associativity::RIGHT_ASSOCIATIVE;
    }
}