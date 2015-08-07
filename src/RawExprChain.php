<?php namespace QueryBuilder;

class RawExprChain implements IExpr {
    /** @var ISql[]|string[] */
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

    public function toSql(ISqlConnection $conn) {
        return Util::joinSql($this->separator, $this->tokens, $conn);
    }
}