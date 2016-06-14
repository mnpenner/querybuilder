<?php namespace QueryBuilder;

use QueryBuilder\AbstractOperator;
use QueryBuilder\Operator\Associativity;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IExprOrInterval;
use QueryBuilder\Interfaces\IOperator;
use QueryBuilder\Interfaces\IPolyadicOperator;
use QueryBuilder\Interfaces\ISqlConnection;

abstract class AbstractPolyadicOperator extends AbstractOperator implements IPolyadicOperator {
    /** @var IExprOrInterval[] */
    protected $operands;

    function __construct(IExprOrInterval ...$operands) {
        $this->operands = $operands;
    }
    
    public function push(IExpr ...$operands) {
        array_push($this->operands, ...$operands);
        return $this;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        $parts = [];
        $op = $this->getOperator();
        $assoc = $this->getAssociativity();
        $opEnd = count($this->operands) - 1;
        foreach($this->operands as $i=>$child) {
            if($child instanceof IOperator) {
                $parts[] = $child->getSqlWrapped($conn, $child->getPrecedence() < $this->getPrecedence()
                    || (
                        $child->getPrecedence() === $this->getPrecedence()
                        && ($assoc !== Associativity::ASSOCIATIVE || $op !== $child->getOperator())
                        && ($assoc !== Associativity::LEFT_ASSOCIATIVE || $i > 0)
                        && ($assoc !== Associativity::RIGHT_ASSOCIATIVE || $i < $opEnd)
                    ),$ctx
                );
            } else {
                $parts[] = $child->_toSql($conn, $ctx);
            }
        }
        if(!$parts) {
            throw new \Exception("Cannot render $op operator; at least 1 operand is required");
            //return "/* empty $op */";
        }
        return implode(" $op ", $parts);
    }

    public function count() {
        return count($this->operands);
    }
}