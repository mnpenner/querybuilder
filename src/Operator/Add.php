<?php namespace QueryBuilder\Operator;

use QueryBuilder\IExprOrInterval;

class Add extends AbstractPolyadicOperator {

    function __construct(IExprOrInterval ...$operands) {
        $this->operands = $operands; // fixme: how to make call to parent c'tor not error?
    }

    public function getOperator() {
        return '+';
    }

    public function getPrecedence() {
        return 7;
    }

    public function isAssociative() {
        return true;
    }
}