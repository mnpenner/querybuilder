<?php namespace QueryBuilder\Interfaces;

use QueryBuilder\Interfaces\IDict;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\IExpr;

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
     * @param bool $needs_parens SQL needs to be wrapped in parentheses to maintain operator precedence
     *
     * @param IDict $ctx
     * @return string SQL
     */
    public function getSqlWrapped(ISqlConnection $conn, $needs_parens, IDict $ctx);
}