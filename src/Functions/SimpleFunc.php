<?php namespace QueryBuilder\Functions;
use QueryBuilder\IExpr;
use QueryBuilder\Util;
use QueryBuilder\ISqlConnection;

/**
 * Represents a syntactically "simple" function. i.e., there are no keywords in the middle of the function parameters.
 */
class SimpleFunc implements IExpr {
    /** @var string */
    protected $func;
    /** @var IExpr[] */
    protected $params;

    function __construct($func, IExpr ...$params) {
        $this->func = Util::keyword($func);
        $this->params = $params;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->func . '(' . implode(', ', array_map(function ($p) use ($conn) {
            /** @var IExpr $p */
            return $p->toSql($conn);
        }, $this->params)).')';
    }
}