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
     * @param ISqlConnection $conn SQL connection
     * @param bool           $needs_parens SQL needs to be wrapped in parentheses to maintain operator precedence
     *
     * @return string SQL
     */
    public function getSqlWrapped(ISqlConnection $conn, $needs_parens);
}