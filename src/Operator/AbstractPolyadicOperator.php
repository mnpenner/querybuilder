<?php namespace QueryBuilder\Operator;

use QueryBuilder\IExpr;
use QueryBuilder\IExprOrInterval;
use QueryBuilder\IOperator;
use QueryBuilder\IPolyadicOperator;
use QueryBuilder\ISqlConnection;

abstract class AbstractPolyadicOperator extends AbstractOperator implements IPolyadicOperator {
    /** @var IExprOrInterval[] */
    protected $operands;

    function __construct(IExprOrInterval ...$operands) {
        $this->operands = $operands;
    }

    /**
     * Append additional operands.
     *
     * @param IExpr[] ...$operands
     * @return $this
     */
    public function push(IExpr ...$operands) {
        array_push($this->operands, ...$operands);
        return $this;
    }

    public function toSql(ISqlConnection $conn) {
        $parts = [];
        $op = $this->getOperator();
        foreach($this->operands as $i=>$child) {
            if($child instanceof IOperator) {
                $parts[] = $child->getSqlWrapped($conn, 
                    ($child->getPrecedence() < $this->getPrecedence()) 
                    || ($child->getPrecedence() === $this->getPrecedence() && $i > 0 && ($op !== $child->getOperator() || $this->getAssociativity() !== Associativity::ASSOCIATIVE))
                );
            } else {
                $parts[] = $child->toSql($conn);
            }
        }
        if(!$parts) {
            throw new \Exception("Cannot render $op operator; at least 1 operand is required");
            //return "/* empty $op */";
        }
        return implode(" $op ", $parts);
    }

    public function operandCount() {
        return count($this->operands);
    }
}