<?php namespace QueryBuilder\Operator;

// fixme: what about the ESCAPE option? https://dev.mysql.com/doc/refman/5.7/en/string-comparison-functions.html#operator_like

class Like extends AbstractPolyadicOperator {

    public function getOperator() {
        return 'LIKE';
    }

    public function getPrecedence() {
        return 11;
    }

    public function isAssociative() {
        return true;
    }
}