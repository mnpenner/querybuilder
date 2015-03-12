<?php namespace QueryBuilder;

interface IPolyadicOperator extends IOperator {
    /**
     * Returns true if this operator is associative.
     *
     * @see http://en.wikipedia.org/wiki/Associative_property
     * @return bool
     */
    public function isAssociative(); // FIXME: should replace with LEFT or RIGHT associativity instead of a bool, like Twig

    /**
     * Returns the number of operands.
     *
     * @return int
     */
    public function operandCount();
}