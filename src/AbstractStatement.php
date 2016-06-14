<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IStatement;

abstract class AbstractStatement extends SqlFrag implements IStatement {

    /**
     * @param callable $fn
     * @return $this
     */
    public function with($fn) {
        call_user_func($fn, $this);
        return $this;
    }
}