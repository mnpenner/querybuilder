<?php namespace QueryBuilder\Nodes;

/**
 * Logical AND
 *
 * Evaluates to 1 if all operands are nonzero and not NULL, to 0 if one or more operands are 0, otherwise NULL is returned.
 */
class AndNode extends AbstractNode {
    public function getType() {
        return 'AND';
    }
}