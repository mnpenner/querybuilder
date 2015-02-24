<?php namespace QueryBuilder;

/**
 * May be transformed into an SQL string
 */
interface ISql {
    /**
     * @param ISqlConnection $conn An active SQL database connection
     * @return string An SQL string
     */
    public function toSql(ISqlConnection $conn);
}