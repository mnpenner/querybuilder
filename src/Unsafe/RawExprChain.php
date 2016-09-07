<?php namespace QueryBuilder\Unsafe;

use QueryBuilder\ExprTrait;
use QueryBuilder\Interfaces\IExpr;

use QueryBuilder\Interfaces\ISqlFrag;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Util;

class RawExprChain implements IExpr {
    use ExprTrait;

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

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return Util::joinSql($this->separator, $this->tokens, $conn, $ctx);
    }
}