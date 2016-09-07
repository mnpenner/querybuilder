<?php namespace QueryBuilder\Unsafe;

use QueryBuilder\ExprTrait;
use QueryBuilder\Unsafe\RawSql;
use QueryBuilder\Interfaces\IExpr;

class RawExpr extends RawSql implements IExpr {
    use ExprTrait;
}