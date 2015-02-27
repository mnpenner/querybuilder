<?php namespace QueryBuilder\Nodes;

// TODO: need to figure out of the "separator" (rename to operator?) is associative or not.
// http://en.wikipedia.org/wiki/Associative_property
// if the operator is NOT associative, like in the 'power' operator then we shouldn't remove
// parentheses for nested nodes.
// But perhaps "Nodes" should only be used for associative lists ['OR', '||', 'XOR', 'AND', '&&', 'UNION', 'UNION ALL', 'UNION DISTINCT'].
// we need to add a new BinaryOperator for mathemetical operators...


// http://dev.mysql.com/doc/refman/5.7/en/non-typed-operators.html
// http://dev.mysql.com/doc/refman/5.7/en/bit-functions.html
// http://dev.mysql.com/doc/refman/5.7/en/logical-operators.html

// Maybe Nodes should *just* be for the logical operators?

use QueryBuilder\IExpr;
use QueryBuilder\ISqlConnection;
use QueryBuilder\Util;

abstract class AbstractNode implements IExpr {
    /** @var IExpr[] */
    protected $children;

    function __construct(IExpr ...$children) {
        $this->children = $children;
    }

    public function push(IExpr ...$children) {
        array_push($this->children, ...$children);
        return $this;
    }

    public function count() {
        return count($this->children);
    }

    /**
     * @return string
     */
    abstract public function getType();

    /**
     * @param ISqlConnection $conn An active SQL database connection
     * @param bool $needsParens
     * @return string An SQL string
     */
    public function toSql(ISqlConnection $conn, $needsParens=false) {
        $parts = [];
        foreach($this->children as $child) {
            if($child instanceof AbstractNode) {
                if($child->count()) { // skip empty nodes
                    $parts[] = $child->toSql($conn, $child->getType() !== $this->getType());
                }
            } else {
                $parts[] = $child->toSql($conn);
            }
        }

        if(!$parts) return '/* empty node */';
        $sql = implode(' '.$this->getType().' ',$parts);
        return $needsParens && count($this->children) > 1 ? "($sql)" : $sql;
    }
}