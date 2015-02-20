<?php namespace QueryBuilder;

class Node implements ISelectExpr {
    /** @var ISelectExpr[] */
    protected $children;
    /** @var string */
    protected $separator;

    function __construct($separator, ISelectExpr ...$children) {
        $this->separator = Util::keyword($separator);
        $this->children = $children;
    }

    public function push(ISelectExpr ...$children) {
        array_push($this->children, ...$children);
    }

    /**
     * @param SqlConnection $conn An active SQL database connection
     * @param bool $needsParens
     * @return string An SQL string
     */
    public function toSql(SqlConnection $conn, $needsParens=false) {
        if(!$this->children) return '/* empty node */';
        $sql = implode(" $this->separator ",array_map(function($x) use ($conn) {
            if($x instanceof Node) {
                return $x->toSql($conn, $x->separator !== $this->separator);
            }
            /** @var $x ISelectExpr */
            return $x->toSql($conn);
        }, $this->children));
        return $needsParens && count($this->children) > 1 ? "($sql)" : $sql;
    }
}