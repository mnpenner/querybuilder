<?php namespace QueryBuilder;

trait CopyTrait {
    /**
     * Returns a copy of the instance.
     *
     * @return $this
     */
    public function copy() {
        return clone $this;
    }
}

