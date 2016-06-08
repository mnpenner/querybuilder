<?php namespace QueryBuilder\Interfaces;
use QueryBuilder\Interfaces\ISqlConnection;

/**
 * May be transformed into an SQL string
 */
interface ISqlFrag {
    /**
     * @param ISqlConnection $conn An active SQL database connection
     * @return string An SQL string
     */
    public function toSql(ISqlConnection $conn);
}