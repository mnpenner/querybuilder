<?php namespace QueryBuilder\Operator;

use QueryBuilder\IExpr;
use QueryBuilder\IOperator;
use QueryBuilder\ISqlConnection;

abstract class AbstractNAryOperator implements IOperator {
    /** @var IExpr[] */
    protected $operands;

    function __construct(IExpr ...$operands) {
        $this->operands = $operands;
    }

    /**
     * Append additional operands.
     *
     * @param IExpr ...$operands
     * @return $this
     */
    public function push(IExpr ...$operands) {
        array_push($this->operands, ...$operands);
        return $this;
    }

    /**
     * @see http://en.wikipedia.org/wiki/Associative_property
     * @return bool
     */
    abstract public function isAssociative();

    public function toSql(ISqlConnection $conn, $needs_parens=false) {
        $parts = [];
        foreach($this->operands as $i=>$child) {
            if($child instanceof IOperator) {
                if($child instanceof AbstractNAryOperator) {
                    if($child->operandCount()) {
                        $parts[] = $child->toSql($conn, $child->getPrecedence() > $this->getPrecedence() || ($i > 0 && !$child->isAssociative()));
                    }
                } else {
                    $parts[] = $child->toSql($conn, $child->getPrecedence() > $this->getPrecedence());
                }
            } else {
                $parts[] = $child->toSql($conn);
            }
        }
        $op = $this->getOperator();
        if(!$parts) return "/* empty $op */";
        $sql = implode(" $op ", $parts);
        return $needs_parens && $this->operandCount() > 1 ? "($sql)" : $sql;
    }

    public function operandCount() {
        return count($this->operands);
    }
}