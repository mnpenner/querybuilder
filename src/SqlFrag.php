<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\ISqlFrag;

abstract class SqlFrag implements ISqlFrag {
    /**
     * @return $this
     */
    public function copy() {
        return clone $this;
    }
}