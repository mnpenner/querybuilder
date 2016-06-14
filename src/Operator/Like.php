<?php namespace QueryBuilder\Operator;

// fixme: what about the ESCAPE option? https://dev.mysql.com/doc/refman/5.7/en/string-comparison-functions.html#operator_like
// "select 'a' like 'a' like 'a'" is a syntax error, however, "select ('a' like 'b') like 'c'" is not
// ergo, if we add the parens, this can be a polyadic operator, otherwise, the binary operatorness will force parens

use QueryBuilder\AbstractBinaryOperator;

class Like extends AbstractBinaryOperator {

    public function getOperator() {
        return 'LIKE';
    }

    public function getPrecedence() {
        return 70;
    }

    public function isAssociative() {
        return true;
    }

    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE;
    }
}