<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IFieldAlias;
use QueryBuilder\Interfaces\ISqlConnection;

trait ExprTrait {
    function asAlias($alias) {
        if(is_string($alias)) {
            $alias = new FieldAlias($alias);
        } elseif($alias instanceof IFieldAlias) {
            // good
        } else {
            throw new \InvalidArgumentException("Alias must be a string or ".IFieldAlias::class);
        }
        /** @noinspection PhpParamsInspection This trait only works on IExpr */
        return new ExprAs($this, $alias);
    }
}
