<?php namespace QueryBuilder\Operator;

use QueryBuilder\IOperator;
use QueryBuilder\ISqlConnection;

abstract class AbstractOperator implements IOperator {

    public function getSqlWrapped(ISqlConnection $conn, $needs_parens=false) {
        $sql = $this->toSql($conn);
        return $needs_parens ? "($sql)" : $sql;
    }
}