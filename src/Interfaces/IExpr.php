<?php namespace QueryBuilder\Interfaces;
use QueryBuilder\Interfaces\IExprOrInterval;

/**
 * May be used in a SELECT clause
 */
interface IExpr extends IExprOrInterval {
    /**
     * @param string|IFieldAlias $alias Alias name
     * @return IField
     */
    function asAlias($alias);
}