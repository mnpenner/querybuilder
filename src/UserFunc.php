<?php namespace QueryBuilder;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IExprOrInterval;
use QueryBuilder\Interfaces\IField;
use QueryBuilder\Interfaces\IInterval;
use QueryBuilder\Util;
use QueryBuilder\Interfaces\ISqlConnection;

/**
 * User-defined function.
 * 
 * Represents a syntactically "simple" function. i.e., there are no keywords in the middle of the function parameters.
 */
class UserFunc implements IExpr {
    use ExprTrait;

    /** @var string */
    protected $func;
    /** @var IExpr[] */
    protected $params;

    function __construct($func, IField ...$params) {
        Util::assertName($func);
        $this->func = $func;
        $this->params = array_map(function($p) {
            /** @var IField $p */
            return $p instanceof IInterval ? $p : $p->getExpr(); // "AS" is never allowed inside a function, use just the "expression" part
        }, $params);
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return $this->func . '(' . Util::joinSql(', ', $this->params, $conn, $ctx).')';
    }
}