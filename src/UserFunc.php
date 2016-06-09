<?php namespace QueryBuilder;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IExprOrInterval;
use QueryBuilder\Util;
use QueryBuilder\Interfaces\ISqlConnection;

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

    public function _toSql(ISqlConnection $conn, \QueryBuilder\Interfaces\IDict $ctx) {
        return $this->func . '(' . Util::joinSql(', ', $this->params, $conn, $ctx).')';
    }
}