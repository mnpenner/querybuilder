<?php namespace QueryBuilder;

/**
 * Returns a count of the number of non-NULL values of expr in the rows retrieved by a SELECT statement. The result is a BIGINT value.
 *
 * COUNT() returns 0 if there were no matching rows.
 *
 * COUNT(*) is somewhat different in that it returns a count of the number of rows retrieved, whether or not they contain NULL values.
 *
 * COUNT(*) is optimized to return very quickly if the SELECT retrieves from one table, no other columns are retrieved, and there is no WHERE clause.
 *
 * This optimization applies only to MyISAM tables only, because an exact row count is stored for this storage engine and can be accessed very quickly. For transactional storage engines such as InnoDB and BDB, storing an exact row count is more problematic because multiple transactions may be occurring, each of which may affect the count.
 */
class Count extends SimpleFunc {
    function __construct(IExpr $expr) {
        parent::__construct('COUNT',$expr);
    }

    /**
     * COUNT(*)
     *
     * @return Count
     */
    public function all() {
        static $func;
        if(!$func) $func = new self(Asterisk::value());
        return $func;
    }
}