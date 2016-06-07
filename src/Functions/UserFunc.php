<?php namespace QueryBuilder\Functions;
use QueryBuilder\IExpr;
use QueryBuilder\IExprOrInterval;
use QueryBuilder\Util;
use QueryBuilder\ISqlConnection;

/**
 * User-defined function.
 * 
 * Represents a syntactically "simple" function. i.e., there are no keywords in the middle of the function parameters.
 */
class UserFunc implements IExpr {
    /** @var string */
    protected $func;
    /** @var IExpr[] */
    protected $params;

    function __construct($func, IExprOrInterval ...$params) {
        Util::assertName($func);
        $this->func = $func;
        $this->params = $params;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->func . '(' . Util::joinSql(', ', $this->params, $conn).')';
    }
}