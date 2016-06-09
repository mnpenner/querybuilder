<?php namespace QueryBuilder\Unsafe;

use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\ISqlFrag;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Util;

class RawExprChain implements IExpr {
    /** @var ISqlFrag[]|string[] */
    private $tokens;
    /** @var string */
    private $separator;

    function __construct($sep, ...$tokens) {
        $this->separator = $sep;
        $this->tokens = $tokens;
    }

    public function append(...$tokens) {
        array_push($this->tokens, ...$tokens);
        return $this;
    }

    public function _toSql(ISqlConnection $conn, \QueryBuilder\Interfaces\IDict $ctx) {
        return Util::joinSql($this->separator, $this->tokens, $conn, $ctx);
    }
}