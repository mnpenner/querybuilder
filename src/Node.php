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

    public function count() {
        return count($this->children);
    }

    /**
     * @param SqlConnection $conn An active SQL database connection
     * @param bool $needsParens
     * @return string An SQL string
     */
    public function toSql(SqlConnection $conn, $needsParens=false) {
        if(!$this->children) return '/* empty node */';

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

        $sql = implode(" $this->separator ",$parts);
        return $needsParens && count($this->children) > 1 ? "($sql)" : $sql;
    }
}