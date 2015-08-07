<?php namespace QueryBuilder\Functions;
use QueryBuilder\IAliasOrColumn;

/**
 * Returns the sum of expr. If the return set has no rows, SUM() returns NULL.
 *
 * SUM() returns NULL if there were no matching rows.
 */
// fixme: move to funcs
class Sum extends SimpleFunc {
    function __construct(IAliasOrColumn $expr) {
        parent::__construct('SUM',$expr);
    }
}