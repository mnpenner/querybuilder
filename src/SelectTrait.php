<?php namespace QueryBuilder;

use QueryBuilder\Joins\Join;
use QueryBuilder\Statements\Select;

trait SelectTrait {
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
    /** @var IField[] */
    protected $fields = [];
    /** @var IExpr */
    protected $where = null;
    /** @var IJoin[] */
    protected $joins = [];

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
    public function innerJoin(ITableAs $table, IExpr $where=null) {
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
     * Overwrites the WHERE condition.
     *
     * Tip: Create a `Node` to set multiple conditions.
     *
     * @param IExpr $expr
     * @return $this
     */
    public function where(IExpr $expr) {
        $this->where = $expr;
        return $this;
    }

    /**
     * @param IField $fields
     * @throws \Exception
     * @return static
     */
    public function fields(IField ...$fields) {
        array_push($this->fields, ...$fields);
        return $this;
    }

    public function toSql(ISqlConnection $conn) {
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
        if(!$this->fields) throw new \Exception("No fields selected");
        if(!Select::getSuppressUnqualifiedAsteriskWarning() && count($this->fields) > 1) {
            foreach($this->fields as $field) {
                if($field instanceof Asterisk && $field->isUnqualified()) {
                    trigger_error("Use of an unqualified * with other items in the select list may produce a parse error. To avoid this problem, use a qualified tbl_name.* reference",E_USER_WARNING);
                }
            }
        }
        $sb[] = implode(', ',array_map(function($field) use ($conn) {
            /** @var IField $field */
            return $field->toSql($conn);
        },$this->fields));
        if($this->tables){
            $sb[] = "\n    FROM ".implode(', ',array_map(function($table) use ($conn) {
                    /** @var ITable $table */
                    return $table->toSql($conn);
                },$this->tables));
        }
        if($this->joins) {
            foreach($this->joins as $join) {
                $sb[] = "\n        ".$join->toSql($conn);
            }
        }
        if($this->where && (!($this->where instanceof IPolyadicOperator) || $this->where->operandCount() > 0)) {
            $sb[] = "\n    WHERE " . $this->where->toSql($conn);
        }
        $orderLimitSql = $this->getOrderLimitSql($conn);
        if(strlen($orderLimitSql)) $sb[] = "\n    ".$orderLimitSql;
        return implode(' ',$sb);
    }
}