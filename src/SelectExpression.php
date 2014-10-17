<?php
namespace QueryBuilder;

/*
http://dev.mysql.com/doc/refman/5.7/en/select.html

select_expression:
	SELECT

	( ALL | DISTINCT | DISTINCTROW )?
	(HIGH_PRIORITY)?
	(STRAIGHT_JOIN)?
	(SQL_SMALL_RESULT)? (SQL_BIG_RESULT)? (SQL_BUFFER_RESULT)?
	(SQL_CACHE_SYM | SQL_NO_CACHE_SYM)? (SQL_CALC_FOUND_ROWS)?

	select_list

	(
		FROM table_references
		( partition_clause )?
		( where_clause )?
		( groupby_clause )?
		( having_clause )?
	) ?

	( orderby_clause )?
	( limit_clause )?
	( ( FOR_SYM UPDATE) | (LOCK IN_SYM SHARE_SYM MODE_SYM) )?
;

SELECT
    [ALL | DISTINCT | DISTINCTROW ]
      [HIGH_PRIORITY]
      [MAX_STATEMENT_TIME = N]
      [STRAIGHT_JOIN]
      [SQL_SMALL_RESULT] [SQL_BIG_RESULT] [SQL_BUFFER_RESULT]
      [SQL_CACHE | SQL_NO_CACHE] [SQL_CALC_FOUND_ROWS]
    select_expr [, select_expr ...]
    [FROM table_references
      [PARTITION partition_list]
    [WHERE where_condition]
    [GROUP BY {col_name | expr | position}
      [ASC | DESC], ... [WITH ROLLUP]]
    [HAVING where_condition]
    [ORDER BY {col_name | expr | position}
      [ASC | DESC], ...]
    [LIMIT {[offset,] row_count | row_count OFFSET offset}]
    [PROCEDURE procedure_name(argument_list)]
    [INTO OUTFILE 'file_name'
        [CHARACTER SET charset_name]
        export_options
      | INTO DUMPFILE 'file_name'
      | INTO var_name [, var_name]]
    [FOR UPDATE | LOCK IN SHARE MODE]]


n.b.
SELECT con_name,* FROM `emr_contact` WHERE 1 is a syntax error
SELECT *,con_name FROM `emr_contact` WHERE 1 is valid
TODO: make immutable
 */
class SelectExpression {
    /** @var bool|null Remove duplicate rows from result set */
    protected $distinct = null;
    /** @var bool Give the select statement higher priority than a statement that updates a table */
    protected $highPriority = false;
    /** @var int Statement execution timeout in ms */
    protected $maxStatementTime = 0;
    /** @var bool Force optimizer to join the tables in the order in which they are listed in the FROM clause */
    protected $straightJoin = false;
    /** @var bool */
    protected $smallResult = false;
    /** @var bool  */
    protected $bigResult = false;
    /** @var bool  */
    protected $bufferResult = false;
    /** @var int */
    protected $cache = SqlCache::DEFAULT_CACHE;
    /** @var bool */
    protected $calcFoundRows = false;

    /**
     * ALL (the default) specifies that all matching rows should be returned, including duplicates.
     */
    public function all() {
        $this->distinct = true;
        return $this;
    }

    /**
     * DISTINCT specifies removal of duplicate rows from the result set.
     */
    public function distinct() {
        $this->distinct = false;
        return $this;
    }

    /**
     * HIGH_PRIORITY gives the SELECT higher priority than a statement that updates a table. You should use this only for queries that are very fast and must be done at once. A SELECT HIGH_PRIORITY query that is issued while the table is locked for reading runs even if there is an update statement waiting for the table to be free. This affects only storage engines that use only table-level locking (such as MyISAM, MEMORY, and MERGE).
     *
     * HIGH_PRIORITY cannot be used with SELECT statements that are part of a UNION.
     *
     * @return $this
     */
    public function highPriority() {
        $this->highPriority = true;
        return $this;
    }

    /**
     * MAX_STATEMENT_TIME = N sets a statement execution timeout of N milliseconds. If this option is absent or N is 0, the statement timeout established by the max_statement_time system variable applies.
     *
     * The MAX_STATEMENT_TIME option is applicable as follows:
     * - It applies to top-level SELECT statements. It does not apply to non-top-level statements, such as subqueries.
     * - It applies to read-only SELECT statements. Statements that are not read only are those that invoke a stored function that modifies data as a side effect.
     * - It does not apply to SELECT statements in stored programs; an error occurs.
     *
     * This option was added in MySQL 5.7.4.
     *
     * @param int $ms Milliseconds
     * @return $this
     */
    public function maxStatementTime($ms) {
        $this->maxStatementTime = $ms;
        return $this;
    }

    /**
     *  STRAIGHT_JOIN forces the optimizer to join the tables in the order in which they are listed in the FROM clause. You can use this to speed up a query if the optimizer joins the tables in nonoptimal order. STRAIGHT_JOIN also can be used in the table_references list.  See Section 13.2.9.2, “JOIN Syntax”.
     *
     * STRAIGHT_JOIN does not apply to any table that the optimizer treats as a const or system table. Such a table produces a single row, is read during the optimization phase of query execution, and references to its columns are replaced with the appropriate column values before query execution proceeds. These tables will appear first in the query plan displayed by EXPLAIN. See Section 8.9.1, “Optimizing Queries with EXPLAIN”. This exception may not apply to const or system tables that are used on the NULL-complemented side of an outer join (that is, the right-side table of a LEFT JOIN or the left-side table of a RIGHT JOIN.
     *
     * @return $this
     */
    public function straightJoin() {
        $this->straightJoin = true;
        return $this;
    }

    /**
     * MySQL directly uses disk-based temporary tables if needed, and prefers sorting to using a temporary table with a key on the GROUP BY elements.
     *
     * @return $this
     */
    public function bigResult() {
        $this->bigResult = true;
        return $this;
    }

    /**
     * MySQL uses fast temporary tables to store the resulting table instead of using sorting. This should not normally be needed.
     *
     * @return $this
     */
    public function smallResult() {
        $this->smallResult = true;
        return $this;
    }

    /**
     * SQL_BUFFER_RESULT forces the result to be put into a temporary table. This helps MySQL free the table locks early and helps in cases where it takes a long time to send the result set to the client. This option can be used only for top-level SELECT statements, not for subqueries or following UNION.
     *
     * @return $this
     */
    public function bufferResult() {
        $this->bufferResult = true;
        return $this;
    }

    /**
     * SQL_CACHE tells MySQL to store the result in the query cache if it is cacheable and the value of the query_cache_type system variable is 2 or DEMAND.
     *
     * For a cacheable query, SQL_CACHE applies if it appears in the first SELECT of a view referred to by the query.
     *
     * @return $this
     */
    public function cache() {
        $this->cache = SqlCache::CACHE;
        return $this;
    }

    /**
     * With SQL_NO_CACHE, the server does not use the query cache. It neither checks the query cache to see whether the result is already cached, nor does it cache the query result.
     *
     * For views, SQL_NO_CACHE applies if it appears in any SELECT in the query.
     *
     * @return $this
     */
    public function noCache() {
        $this->cache = SqlCache::NO_CACHE;
        return $this;
    }

    /**
     * Tells MySQL to calculate how many rows there would be in the result set, disregarding any LIMIT clause. The number of rows can then be retrieved with SELECT FOUND_ROWS().
     *
     * @return $this
     */
    public function calcFoundRows() {
        $this->calcFoundRows = true;
        return $this;
    }


    /**
     * @param $columns
     * @return $this
     */
    public function select(...$columns) {

        return $this;
    }

    public function toSql(SqlConnection $sql) {
        $sb = ['SELECT'];
        if($this->distinct === true) $sb[] = 'DISTINCT';
        elseif($this->distinct === false) $sb[] = 'ALL';
        if($this->maxStatementTime !== 0) $sb[] = 'MAX_STATEMENT_TIME = '.$this->maxStatementTime;
        if($this->straightJoin) $sb[] = 'STRAIGHT_JOIN';
        if($this->smallResult) $sb[] = 'SQL_SMALL_RESULT';
        if($this->bigResult) $sb[] = 'SQL_BIG_RESULT';
        if($this->bufferResult) $sb[] = 'SQL_BUFFER_RESULT';
        if($this->cache === SqlCache::CACHE) $sb[] = 'SQL_CACHE';
        elseif($this->cache === SqlCache::NO_CACHE) $sb[] = 'SQL_NO_CACHE';
        if($this->calcFoundRows) $sb[] = 'SQL_CALC_FOUND_ROWS';

        return implode(' ',$sb);
    }
}