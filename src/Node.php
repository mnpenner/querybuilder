<?php namespace QueryBuilder;

// TODO: need to figure out of the "separator" (rename to operator?) is associative or not.
// http://en.wikipedia.org/wiki/Associative_property
// if the operator is NOT associative, like in the 'power' operator then we shouldn't remove
// parentheses for nested nodes.
// But perhaps "Nodes" should only be used for associative lists ['OR', '||', 'XOR', 'AND', '&&', 'UNION', 'UNION ALL', 'UNION DISTINCT'].
// we need to add a new BinaryOperator for mathemetical operators...

// TODO: should we make this abstract? and add an abstract 'getSeparator' (operator?) method instead

class Node implements IExpr {
    /** @var IExpr[] */
    protected $children;
    /** @var string */
    protected $separator;

    function __construct($separator, IExpr ...$children) {
        $this->separator = Util::keyword($separator);
        $this->children = $children;
    }

    public function push(IExpr ...$children) {
        array_push($this->children, ...$children);
    }

    public function count() {
        return count($this->children);
    }

    /**
     * @param ISqlConnection $conn An active SQL database connection
     * @param bool $needsParens
     * @return string An SQL string
     */
    public function toSql(ISqlConnection $conn, $needsParens=false) {
        $parts = [];
        foreach($this->children as $child) {
            if($child instanceof Node) {
                if($child->count()) { // skip empty nodes
                    $parts[] = $child->toSql($conn, $child->separator !== $this->separator);
                }
            } else {
                $parts[] = $child->toSql($conn);
            }
        }

        if(!$parts) return '/* empty node */';
        $sql = implode(" $this->separator ",$parts);
        return $needsParens && count($this->children) > 1 ? "($sql)" : $sql;
    }
}