<?php namespace QueryBuilder;

use QueryBuilder\PolyadicOperator;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IOperator;
use QueryBuilder\Interfaces\ISqlConnection;

abstract class BinaryOperator extends PolyadicOperator implements IOperator {
    function __construct(IExpr $left, IExpr $right) {
        parent::__construct($left, $right);
    }
}