<?php namespace QueryBuilder\Functions;
use QueryBuilder\IExpr;
use QueryBuilder\IFunc;
use QueryBuilder\ISqlConnection;

/**
 * Returns a count of the number of rows with different non-NULL expr values.
 *
 * COUNT(DISTINCT) returns 0 if there were no matching rows.
 *
 * In MySQL, you can obtain the number of distinct expression combinations that do not contain NULL by giving a list of expressions. In standard SQL, you would have to do a concatenation of all expressions inside COUNT(DISTINCT ...).
 */
class CountDistinct implements IFunc {
    /** @var IExpr[] */
    protected $params;

    function __construct(IExpr ...$params) {
        $this->params = $params;
    }

    public function toSql(ISqlConnection $conn) {
        return 'COUNT(DISTINCT ' . implode(', ', array_map(function($p) use ($conn) {
            /** @var IExpr $p */
            return $p->toSql($conn);
        }, $this->params));
    }
}