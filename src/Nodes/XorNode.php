<?php namespace QueryBuilder\Nodes;

/**
 * Logical XOR
 *
 * Returns NULL if either operand is NULL. For non-NULL operands, evaluates to 1 if an odd number of operands is nonzero, otherwise 0 is returned.
 *
 * a XOR b is mathematically equal to (a AND (NOT b)) OR ((NOT a) and b).
 */
class XorNode extends AbstractNode {
    public function getType() {
        return 'XOR';
    }
}