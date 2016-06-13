<?php namespace QueryBuilder;

abstract class Statement extends SqlFrag {

    /**
     * @param callable $fn
     * @return $this
     */
    public function with($fn) {
        call_user_func($fn, $this);
        return $this;
    }
}