<?php namespace QueryBuilder;

use QueryBuilder\AbstractPolyadicOperator;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IOperator;
use QueryBuilder\Interfaces\ISqlConnection;

abstract class AbstractBinaryOperator extends AbstractPolyadicOperator implements IOperator {
    function __construct(IExpr $left, IExpr $right) {
        parent::__construct($left, $right);
    }
}