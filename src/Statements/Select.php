<?php namespace QueryBuilder\Statements;

use QueryBuilder\Asterisk;
use QueryBuilder\GroupByList;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IField;
use QueryBuilder\Interfaces\IGroupByList;
use QueryBuilder\Interfaces\IJoin;
use QueryBuilder\Interfaces\IOrder;
use QueryBuilder\Interfaces\IPolyadicOperator;
use QueryBuilder\Interfaces\ISelect;
use QueryBuilder\Interfaces\ISelectList;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\ITable;
use QueryBuilder\Interfaces\ITableAs;
use QueryBuilder\Join;
use QueryBuilder\Operator\LogicalAnd;
use QueryBuilder\Operator\LogicalOr;
use QueryBuilder\OrderByList;
use QueryBuilder\OrderLimitTrait;
use QueryBuilder\SelectExpr;
use QueryBuilder\AbstractStatement;
use QueryBuilder\SelectList;

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
TODO: make immutable (maybe..?)
 */


class Select extends AbstractStatement implements ISelect {
    use OrderLimitTrait;

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
    /** @var bool|null */
    protected $cache = null;
    /** @var bool */
    protected $calcFoundRows = false;
    /** @var ITable[] */
    protected $tables = [];
    /** @var SelectList */
    protected $fieldList;
    /** @var GroupByList */
    protected $groupList;
    /** @var IExpr */
    protected $where = null;
    /** @var IExpr */
    protected $having = null;
    /** @var IJoin[] */
    protected $joins = [];

    public function __construct() {
        $this->fieldList = new SelectList;
        $this->groupList = new GroupByList;
        $this->orderList = new OrderByList;
    }
    
    /**
     * Group by one or more fields.
     *
     * @param IGroupByList $fieldList
     * @return $this
     */
    public function setGroupBy(IGroupByList $fieldList) {
        // Using IOrder here because:
        // "MySQL extends the GROUP BY clause so that you can also specify ASC and DESC after columns named in the clause"
        $this->groupList = new GroupByList($fieldList);
        return $this;
    }

    /**
     * Append to GROUP BY clause.
     * 
     * @param \QueryBuilder\Interfaces\IOrder[] ...$field
     * @return $this
     */
    public function groupBy(IOrder ...$field) {
        $this->groupList->append(...$field);
        return $this;
    }

    /**
     * Prepend to GROUP BY clause.
     *
     * @param \QueryBuilder\Interfaces\IOrder[] ...$field
     * @return $this
     */
    public function preGroupBy(IOrder ...$field) {
        $this->groupList->prepend(...$field);
        return $this;
    }

    /**
     * ALL (the default) specifies that all matching rows should be returned, including duplicates.
     */
    public function all() {
        $this->distinct = false;
        return $this;
    }

    /**
     * DISTINCT specifies removal of duplicate rows from the result set.
     *
     * @param bool $enable
     * @return $this
     */
    public function distinct($enable=true) {
        $this->distinct = $enable;
        return $this;
    }

    /**
     * HIGH_PRIORITY gives the SELECT higher priority than a statement that updates a table. You should use this only for queries that are very fast and must be done at once. A SELECT HIGH_PRIORITY query that is issued while the table is locked for reading runs even if there is an update statement waiting for the table to be free. This affects only storage engines that use only table-level locking (such as MyISAM, MEMORY, and MERGE).
     *
     * HIGH_PRIORITY cannot be used with SELECT statements that are part of a UNION.
     *
     * @param bool $enable
     * @return static
     */
    public function highPriority($enable=true) {
        $this->highPriority = $enable;
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
     * The `SELECT MAX_STATEMENT_TIME = N ...` syntax is not valid in MariaDB.
     *
     * @param int $ms Milliseconds
     * @return static
     */
    public function maxStatementTime($ms) {
        $this->maxStatementTime = $ms;
        return $this;
    }

    /**
     * STRAIGHT_JOIN forces the optimizer to join the tables in the order in which they are listed in the FROM clause. You can use this to speed up a query if the optimizer joins the tables in nonoptimal order. STRAIGHT_JOIN also can be used in the table_references list.  See Section 13.2.9.2, “JOIN Syntax”.
     *
     * STRAIGHT_JOIN does not apply to any table that the optimizer treats as a const or system table. Such a table produces a single row, is read during the optimization phase of query execution, and references to its columns are replaced with the appropriate column values before query execution proceeds. These tables will appear first in the query plan displayed by EXPLAIN. See Section 8.9.1, “Optimizing Queries with EXPLAIN”. This exception may not apply to const or system tables that are used on the NULL-complemented side of an outer join (that is, the right-side table of a LEFT JOIN or the left-side table of a RIGHT JOIN.
     *
     * @param bool $enable
     * @return static
     */
    public function straightJoinTables($enable=true) {
        $this->straightJoin = $enable;
        return $this;
    }

    /**
     * Adds tables to be joined.
     *
     * @param IJoin[] ...$joins
     * @return $this
     */
    public function join(IJoin ...$joins) {
        array_push($this->joins, $joins);
        return $this;
    }

    /**
     * (INNER) JOIN
     *
     * In MySQL, JOIN, CROSS JOIN, and INNER JOIN are syntactic equivalents (they can replace each other). In standard SQL, they are not equivalent. INNER JOIN is used with an ON clause, CROSS JOIN is used otherwise.
     *
     * @param ITableAs $table
     * @param IExpr|null $where
     * @return $this
     */
    public function innerJoin(ITableAs $table, IExpr $where=null) { // ON clause is optional for INNER JOINs, but required for LEFT JOINs
        $this->joins[] = new Join('INNER JOIN', $table, $where);
        return $this;
    }

    /**
     * STRAIGHT_JOIN
     *
     * STRAIGHT_JOIN is similar to JOIN, except that the left table is always read before the right table. This can be used for those (few) cases for which the join optimizer puts the tables in the wrong order.
     *
     * @param ITableAs $table
     * @param IExpr $where
     * @return $this
     */
    public function straightJoin(ITableAs $table, IExpr $where) {
        $this->joins[] = new Join('STRAIGHT_JOIN', $table, $where);
        return $this;
    }

    /**
     * LEFT (OUTER) JOIN
     *
     * If there is no matching row for the right table in the ON or USING part in a LEFT JOIN, a row with all columns set to NULL is used for the right table. You can use this fact to find rows in a table that have no counterpart in another table.
     *
     * @param ITableAs $table
     * @param IExpr $where
     * @return $this
     */
    public function leftJoin(ITableAs $table, IExpr $where) {
        $this->joins[] = new Join('LEFT JOIN', $table, $where);
        return $this;
    }

    /**
     * RIGHT (OUTER) JOIN
     *
     * @param ITableAs $table
     * @param IExpr $where
     * @return $this
     */
    public function rightJoin(ITableAs $table, IExpr $where) {
        $this->joins[] = new Join('RIGHT JOIN', $table, $where);
        return $this;
    }

    /**
     * NATURAL (INNER) JOIN.
     *
     * @param ITableAs $table
     * @return $this
     */
    public function naturalJoin(ITableAs $table) {
        $this->joins[] = new Join('NATURAL JOIN',$table);
        return $this;
    }

    /**
     * NATURAL LEFT (OUTER) JOIN.
     *
     * @param ITableAs $table
     * @return $this
     */
    public function naturalLeftJoin(ITableAs $table) {
        $this->joins[] = new Join('NATURAL LEFT JOIN',$table);
        return $this;
    }

    /**
     * NATURAL RIGHT (OUTER) JOIN
     *
     * @param ITableAs $table
     * @return $this
     */
    public function naturalRightJoin(ITableAs $table) {
        $this->joins[] = new Join('NATURAL RIGHT JOIN',$table);
        return $this;
    }

    // TODO: should we add an outerJoin method that generates something like: (SELECT ... FROM tbl1 LEFT JOIN tbl2 ...) UNION ALL (SELECT ... FROM tbl1 RIGHT JOIN tbl2 ... WHERE tbl1.col IS NULL) ??

    /**
     * MySQL directly uses disk-based temporary tables if needed, and prefers sorting to using a temporary table with a key on the GROUP BY elements.
     *
     * @return static
     */
    public function bigResult() {
        $this->bigResult = true;
        return $this;
    }

    /**
     * MySQL uses fast temporary tables to store the resulting table instead of using sorting. This should not normally be needed.
     *
     * @return static
     */
    public function smallResult() {
        $this->smallResult = true;
        return $this;
    }

    /**
     * SQL_BUFFER_RESULT forces the result to be put into a temporary table. This helps MySQL free the table locks early and helps in cases where it takes a long time to send the result set to the client. This option can be used only for top-level SELECT statements, not for subqueries or following UNION.
     *
     * @return static
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
     * @return static
     */
    public function cache() {
        $this->cache = true;
        return $this;
    }

    /**
     * With SQL_NO_CACHE, the server does not use the query cache. It neither checks the query cache to see whether the result is already cached, nor does it cache the query result.
     *
     * For views, SQL_NO_CACHE applies if it appears in any SELECT in the query.
     *
     * @return static
     */
    public function noCache() {
        $this->cache = false;
        return $this;
    }

    /**
     * Tells MySQL to calculate how many rows there would be in the result set, disregarding any LIMIT clause. The number of rows can then be retrieved with SELECT FOUND_ROWS().
     *
     * @return static
     */
    public function calcFoundRows() {
        $this->calcFoundRows = true;
        return $this;
    }

    /**
     * Adds tables to be selected FROM.
     *
     * @param ITableAs[] ...$tables
     * @return $this
     */
    public function from(ITableAs ...$tables) {
        array_push($this->tables, ...$tables);
        return $this;
    }

    /**
     * Replaces the WHERE criteria.
     *
     * @param IExpr $expr
     * @return $this
     */
    public function where(IExpr $expr) {
        $this->where = $expr;
        return $this;
    }

    /**
     * Adds criteria to the WHERE clause, AND'd with the existing criteria
     * 
     * @param IExpr $expr
     * @return $this
     */
    public function andWhere(IExpr $expr) {
        $this->where = $this->where ? new LogicalAnd($this->where, $expr) : $expr;
        return $this;
    }

    /**
     * Adds criteria to the WHERE clause, OR'd with the existing criteria
     * 
     * @param IExpr $expr
     * @return $this
     */
    public function orWhere(IExpr $expr) {
        $this->where = $this->where ? new LogicalOr($this->where, $expr) : $expr;
        return $this;
    }

    /**
     * Replaces the HAVING criteria.
     *
     * @param IExpr $expr
     * @return $this
     */
    public function having(IExpr $expr) {
        $this->having = $expr;
        return $this;
    }

    /**
     * Adds criteria to the HAVING clause, AND'd with the existing criteria
     *
     * @param IExpr $expr
     * @return $this
     */
    public function andHaving(IExpr $expr) {
        $this->having = $this->having ? new LogicalAnd($this->having, $expr) : $expr;
        return $this;
    }

    /**
     * Adds criteria to the HAVING clause, OR'd with the existing criteria
     *
     * @param IExpr $expr
     * @return $this
     */
    public function orHaving(IExpr $expr) {
        $this->having = $this->having ? new LogicalOr($this->having, $expr) : $expr;
        return $this;
    }

    /**
     * Append fields to the SELECT clause.
     * 
     * @param IField[] $fields
     * @return $this
     */
    public function fields(IField ...$fields) {
        $this->fieldList->append(...$fields);
        return $this;
    }

    /**
     * Prepend fields to the SELECT clause.
     *
     * @param IField[] $fields
     * @return $this
     */
    public function preFields(IField ...$fields) {
        $this->fieldList->append(...$fields);
        return $this;
    }
    
    /**
     * Replaces the SELECT fields list.
     * 
     * @param ISelectList $fields
     * @return $this
     */
    public function setFields(ISelectList $fields) {
        $this->fieldList = new SelectList($fields);
        return $this;
    }
    
    /**
     * Converts this SELECT statement into an expression for use as a sub-query.
     * 
     * @return SelectExpr
     */
    public function toExpr() {
        return new SelectExpr($this);
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        $sb = ['SELECT'];
        if($this->distinct === true) $sb[] = 'DISTINCT';
        elseif($this->distinct === false) $sb[] = 'ALL';
        if($this->highPriority) $sb[] = 'HIGH_PRIORITY';
        if($this->maxStatementTime !== 0) $sb[] = 'MAX_STATEMENT_TIME = '.$this->maxStatementTime;
        if($this->straightJoin) $sb[] = 'STRAIGHT_JOIN';
        if($this->smallResult) $sb[] = 'SQL_SMALL_RESULT';
        if($this->bigResult) $sb[] = 'SQL_BIG_RESULT';
        if($this->bufferResult) $sb[] = 'SQL_BUFFER_RESULT';
        if($this->cache === true) $sb[] = 'SQL_CACHE';
        elseif($this->cache === false) $sb[] = 'SQL_NO_CACHE';
        if($this->calcFoundRows) $sb[] = 'SQL_CALC_FOUND_ROWS';
        
        /** @var IField[] $fields */
        $fields = iterator_to_array($this->fieldList,false);
        /** @var IOrder[] $groupBy */
        $groupBy = iterator_to_array($this->groupList,false);

        if(!$fields) throw new \Exception("No fields selected");
        
        for($i=1; $i<count($fields); ++$i) {
            if($i && $fields[$i] instanceof Asterisk && $fields[$i]->isUnqualified()) {
                throw new \Exception("An unqualified * may only be used as the first field in the SELECT list. Either move it to the start or prefix it with a table name. Found in position $i.");
            }
        }

//        if(!Select::getSuppressUnqualifiedAsteriskWarning() && count($this->fields) > 1) {
//            foreach($this->fields as $field) {
//                if($field instanceof Asterisk && $field->isUnqualified()) {
//                    // FIXME: In practice, MySQL only errors if * is not the first argument
//                    trigger_error("Use of an unqualified * with other items in the select list may produce a parse error. To avoid this problem, use a qualified tbl_name.* reference",E_USER_WARNING);
//                }
//            }
//        }
        $sb[] = implode(', ',array_map(function($field) use ($conn, &$ctx) {
            /** @var IField $field */
            return $field->_toSql($conn,$ctx);
        },$fields));
        if($this->tables){
            $sb[] = "\n    FROM ".implode(', ',array_map(function($table) use ($conn, &$ctx) {
                    /** @var ITable $table */
                    return $table->_toSql($conn,$ctx);
                },$this->tables));
        }
        if($this->joins) {
            foreach($this->joins as $join) {
                $sb[] = "\n        ".$join->_toSql($conn, $ctx);
            }
        }
        if($this->where && (!($this->where instanceof IPolyadicOperator) || $this->where->count() > 0)) {
            $sb[] = "\n    WHERE " . $this->where->_toSql($conn, $ctx);
        }
        if($groupBy) {
            $sb[] = "\n    GROUP BY ".implode(', ',array_map(function($group) use ($conn, &$ctx) {
                    /** @var IOrder $group */
                    return $group->_toSql($conn,$ctx);
                },$groupBy));
        }
        if($this->having && (!($this->having instanceof IPolyadicOperator) || $this->having->count() > 0)) {
            $sb[] = "\n    HAVING " . $this->having->_toSql($conn, $ctx);
        }
        $orderLimitSql = $this->getOrderLimitSql($conn, $ctx);
        if(strlen($orderLimitSql)) $sb[] = "\n    ".$orderLimitSql;
        return implode(' ',$sb);
    }
}