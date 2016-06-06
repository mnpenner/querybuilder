<?php namespace QueryBuilder\Functions;

use QueryBuilder\ISelect;
use QueryBuilder\ITable;
use QueryBuilder\ITableAs;
use QueryBuilder\Statements\Select;

abstract class Stmt {


    /**
     * @param ITableAs[] ...$tables
     * @return Select
     */
    public static function select(ITableAs... $tables) {
        $select = new Select();
        if($tables) $select->from(...$tables);
        return $select;
    }
}