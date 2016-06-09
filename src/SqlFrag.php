<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\ISqlFrag;

/**
 * May be transformed into an SQL string
 */
abstract class SqlFrag implements ISqlFrag {
    /**
     * @return $this
     */
    public function copy() {
        return clone $this;
    }
}