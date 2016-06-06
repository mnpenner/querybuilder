<?php namespace QueryBuilder\Operator;

use QueryBuilder\IOperator;
use QueryBuilder\ISqlConnection;
use QueryBuilder\SqlFrag;

abstract class AbstractOperator extends SqlFrag implements IOperator {

    public function getSqlWrapped(ISqlConnection $conn, $needs_parens=false) {
        $sql = $this->toSql($conn);
        return $needs_parens ? "($sql)" : $sql;
    }
}