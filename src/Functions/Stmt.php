<?php namespace QueryBuilder\Functions;

use QueryBuilder\ISelect;
use QueryBuilder\ITable;
use QueryBuilder\ITableAs;
use QueryBuilder\Statements\Select;

/**
 * @deprecated Move to "nice" query builder
 */
abstract class Stmt {

    /**
     * @return Select
     */
    public static function select() {
        return new Select();
    }
}