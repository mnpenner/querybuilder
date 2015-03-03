<?php namespace QueryBuilder\Operator;

use QueryBuilder\IExpr;
use QueryBuilder\IOperator;
use QueryBuilder\IPolyadicOperator;
use QueryBuilder\ISqlConnection;

abstract class AbstractPolyadicOperator implements IPolyadicOperator {
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

    public function toSql(ISqlConnection $conn, $needs_parens=false) {
        $parts = [];
        foreach($this->operands as $i=>$child) {
            if($child instanceof IPolyadicOperator) {
                if($child->operandCount()) {
                    $parts[] = $child->toSql($conn, $child->getPrecedence() > $this->getPrecedence() || ($i > 0 && (!$this->isAssociative() || !$child->isAssociative())));
                }
            } elseif($child instanceof IOperator) {
                $parts[] = $child->toSql($conn, $child->getPrecedence() > $this->getPrecedence());
            } else {
                $parts[] = $child->toSql($conn);
            }
        }
        $op = $this->getOperator();
        if(!$parts) {
            throw new \Exception("Cannot render $op operator; at least 1 operand is required");
            //return "/* empty $op */";
        }
        $sql = implode(" $op ", $parts);
        return $needs_parens && $this->operandCount() > 1 ? "($sql)" : $sql;
    }

    public function operandCount() {
        return count($this->operands);
    }
}