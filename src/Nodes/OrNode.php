<?php namespace QueryBuilder\Nodes;

/**
 * Logical OR
 *
 * When both operands are non-NULL, the result is 1 if any operand is nonzero, and 0 otherwise. With a NULL operand, the result is 1 if the other operand is nonzero, and NULL otherwise. If both operands are NULL, the result is NULL.
 */
class OrNode extends AbstractNode {
    public function getType() {
        return 'OR';
    }
}