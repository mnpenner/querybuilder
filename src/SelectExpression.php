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

TODO: make immutable
 */
class SelectExpression {
    /** @var bool Remove duplicate rows from result set */
    protected $distinct = false;
    /** @var bool Give the select statement higher priority than a statement that updates a table */
    protected $highPriority = false;
    /** @var int Statement execution timeout in ms */
    protected $maxStatementTime = 0;

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
     */
    public function maxStatementTime($ms) {
        $this->maxStatementTime = $ms;
    }
}