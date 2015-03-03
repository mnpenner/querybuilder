<?php namespace QueryBuilder;

interface IOperator extends IExpr {
    /**
     * Gets the operator.
     *
     * @return string
     */
    public function getOperator();

    /**
     * Gets the operator's precedence.
     *
     * The lower the number, the higher the precendence.
     *
     * Operators with high precedence are evaluated before operators with low precedence. For example, the multiplication operator (*) has higher preference than the addition operator (+).
     *
     * @return int
     */
    public function getPrecedence();

    /**
     * @return int
     */
    public function operandCount();

    /**
     * @see http://en.wikipedia.org/wiki/Associative_property
     * @return bool
     */
    public function isAssociative();
}