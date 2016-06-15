<?php namespace QueryBuilder\Operator;

class NotLike extends Like {
    public function getOperator() {
        return 'NOT LIKE';
    }
}