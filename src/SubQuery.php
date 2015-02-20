<?php namespace QueryBuilder;

/**
 * A subquery is a SELECT statement within another statement.
 *
 * NOTES:
 * A subquery must always appear within parentheses.
 *
 *
 * Exits subquery http://dev.mysql.com/doc/refman/5.7/en/exists-and-not-exists-subqueries.html
 * Traditionally, an EXISTS subquery starts with SELECT *, but it could begin with SELECT 5 or SELECT column1 or anything at all. MySQL ignores the SELECT list in such a subquery, so it makes no difference.
 */

class SubQuery implements ISelectExpr, ITableRef {
    /**
     * @param SqlConnection $sql An active SQL database connection
     * @return string An SQL string
     */
    public function toSql(SqlConnection $sql) {
        // TODO: Implement toSql() method.
    }
}