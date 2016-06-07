<?php namespace QueryBuilder\Operator;

use QueryBuilder\IExpr;
use QueryBuilder\IOperator;
use QueryBuilder\ISqlConnection;

abstract class AbstractBinaryOperator extends AbstractPolyadicOperator implements IOperator {
    function __construct(IExpr $left, IExpr $right) {
        parent::__construct($left, $right);
    }
}