<?php namespace QueryBuilder\Statements;

use QueryBuilder\CopyTrait;
use QueryBuilder\ISelect;
use QueryBuilder\IStatement;
use QueryBuilder\SelectTrait;
use QueryBuilder\SqlFrag;
use QueryBuilder\Statement;

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


class Select extends Statement implements ISelect {
    use CopyTrait;
    use SelectTrait;
    protected static $suppressUnqualifiedAsteriskWarning = false;

//    public static function suppressUnqualifiedAsteriskWarning($enabled = true) {
//        self::$suppressUnqualifiedAsteriskWarning = $enabled;
//    }
//
//    public static function getSuppressUnqualifiedAsteriskWarning(){
//        return self::$suppressUnqualifiedAsteriskWarning;
//    }
}