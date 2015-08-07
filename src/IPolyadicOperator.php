<?php namespace QueryBuilder;

interface IPolyadicOperator extends IOperator {
    /**
     * Returns true if this operator is associative.
     *
     * Operators may be associative (meaning the operations can be grouped arbitrarily), left-associative (meaning the operations are grouped from the left), right-associative (meaning the operations are grouped from the right) or non-associative (meaning operations can not be chained, often because the output type is incompatible with the input types).
     *
     * @see https://en.wikipedia.org/wiki/Operator_associativity
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