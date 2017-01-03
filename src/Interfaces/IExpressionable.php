<?php namespace QueryBuilder\Interfaces;

/**
 * Represents something that can be converted to an expression.
 */
interface IExpressionable {

    /**
     * @return IExpr
     */
    public function getExpr();
}