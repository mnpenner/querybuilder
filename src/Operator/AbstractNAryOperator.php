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

    public function toSql(ISqlConnection $conn, $needs_parens=false) {
        $parts = [];
        foreach($this->operands as $child) {
            if($child instanceof IOperator) {
                if($child->operandCount()) {
                    // (1<<2)<<3 is not the same as 1<<(2<<3); we need to add parentheses to control associativity
                    // (1+2)-3 is the same as 1+(2-3) however, so no need to add extra parens
                    $parts[] = $child->toSql($conn, $child->getPrecedence() !== $this->getPrecedence() || !$child->isAssociative());
                }
            } else {
                $parts[] = $child->toSql($conn);
            }
        }
        if(!$parts) return '/* empty node */';
        $op = $this->getOperator();
        $sql = implode(strlen($op) > 1 ? " $op " : $op, $parts);
        return $needs_parens && $this->operandCount() > 1 ? "($sql)" : $sql;
    }

    public function operandCount() {
        return count($this->operands);
    }
}