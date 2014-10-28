<?php
namespace QueryBuilder;

/**
 * May be transformed into an SQL string
 */
interface ISql {
    /**
     * @param SqlConnection $sql An active SQL database connection
     * @return string An SQL string
     */
    public function toSql(SqlConnection $sql);
}