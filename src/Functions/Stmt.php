<?php namespace QueryBuilder\Functions;

use QueryBuilder\ISelect;
use QueryBuilder\ITable;
use QueryBuilder\Statements\Select;

abstract class Stmt {


    /**
     * @param ITable ...$tables
     * @return Select
     */
    public static function select(ITable... $tables) {
        $select = new Select();
        if($tables) $select->from(...$tables);
        return $select;
    }
}