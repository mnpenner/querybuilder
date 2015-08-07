<?php namespace QueryBuilder\MySql;

use QueryBuilder\ISelect;
use QueryBuilder\RawExprChain;

/**
 * Aggregate functions
 */
abstract class Agg {


    public static function exists(ISelect $select) {
        return new RawExprChain('','EXISTS(',$select,')');
    }

    // todo: add countAll(), countDistinct(), countNotNull() etc
}