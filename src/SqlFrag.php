<?php namespace QueryBuilder;

abstract class SqlFrag implements ISql {
    /**
     * @return $this
     */
    public function copy() {
        return clone $this;
    }
}