<?php namespace QueryBuilder\Functions;
use QueryBuilder\IAlias;

/**
 * Returns the sum of expr. If the return set has no rows, SUM() returns NULL.
 *
 * SUM() returns NULL if there were no matching rows.
 */
class Sum extends SimpleFunc {
    function __construct(IAlias $expr) {
        parent::__construct('SUM',$expr);
    }
}