<?php namespace QueryBuilder\MySql;

use QueryBuilder\Asterisk;
use QueryBuilder\Functions\SimpleFunc;
use QueryBuilder\IAliasOrColumn;
use QueryBuilder\IColumn;
use QueryBuilder\IExpr;
use QueryBuilder\ISelect;
use QueryBuilder\RawExpr;
use QueryBuilder\RawExprChain;

/**
 * Aggregate functions
 * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html
 */
abstract class Agg {


    /**
     * @param ISelect $select
     * @return IExpr
     */
    public static function exists(ISelect $select) {
        return new RawExprChain('','EXISTS(',$select,')');
    }

    /**
     * Returns the sum of expr. If the return set has no rows, SUM() returns NULL. The DISTINCT keyword can be used to sum only the distinct values of expr.
     *
     * SUM() returns NULL if there were no matching rows.
     *
     * @param IExpr $expr
     * @param bool $distinct
     * @return IExpr
     */
    public static function sum(IExpr $expr, $distinct=false) {
        $chain = new RawExprChain('','SUM(');
        if($distinct) $chain->append('DISTINCT ');
        return $chain->append($expr,')');
    }

    /**
     * Returns the average value of expr. The DISTINCT option can be used to return the average of the distinct values of expr.
     *
     * AVG() returns NULL if there were no matching rows.
     *
     * @param IExpr $expr
     * @param bool $distinct
     * @return IExpr
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_avg
     */
    public static function avg(IExpr $expr, $distinct=false) {
        $chain = new RawExprChain('','AVG(');
        if($distinct) $chain->append('DISTINCT ');
        return $chain->append($expr,')');
    }

    /**
     * Returns the bitwise AND of all bits in expr. The calculation is performed with 64-bit (BIGINT) precision.
     *
     * This function returns 18446744073709551615 if there were no matching rows. (This is the value of an unsigned BIGINT value with all bits set to 1.)
     *
     * @param IExpr $expr
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_bit-and
     */
    public static function bitAnd(IExpr $expr) {
        return new SimpleFunc('BIT_AND', $expr);
    }

    /**
     * Returns the bitwise OR of all bits in expr. The calculation is performed with 64-bit (BIGINT) precision.
     *
     * This function returns 0 if there were no matching rows.
     *
     * @param IExpr $expr
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_bit-or
     */
    public static function bitOr(IExpr $expr) {
        return new SimpleFunc('BIT_OR', $expr);
    }

    /**
     * Returns the bitwise XOR of all bits in expr. The calculation is performed with 64-bit (BIGINT) precision.
     *
     * This function returns 0 if there were no matching rows.
     *
     * @param IExpr $expr
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_bit-xor
     */
    public static function bitXor(IExpr $expr) {
        return new SimpleFunc('BIT_XOR', $expr);
    }

    /**
     * Returns a count of the number of non-NULL values of `col` in the rows retrieved by a SELECT statement. The result is a BIGINT value.
     *
     * Returns 0 if there were no matching rows.
     *
     * @param IColumn $col
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_count
     */
    public static function countNonNull(IColumn $col) {
        return new SimpleFunc('COUNT',$col);
    }

    /**
     * Returns a count of the number of rows retrieved, whether or not they contain NULL values.
     *
     * Optimized to return very quickly if the SELECT retrieves from one table, no other columns are retrieved, and there is no WHERE clause.
     *
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_count
     */
    public static function countRows() {
        return new RawExpr('COUNT(*)');
    }

    /**
     * Returns a count of the number of rows with different non-NULL expr values.
     *
     * COUNT(DISTINCT) returns 0 if there were no matching rows.
     *
     * In MySQL, you can obtain the number of distinct expression combinations that do not contain NULL by giving a list of expressions. In standard SQL, you would have to do a concatenation of all expressions inside COUNT(DISTINCT ...).
     *
     * @param IColumn ...$cols
     * @return RawExprChain
     * @return https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_count-distinct
     */
    public static function countDistinct(IColumn ...$cols) {
        return new RawExprChain('','COUNT(DISTINCT ',new RawExprChain(', ', ...$cols),')');
    }

    /**
     * Returns the maximum value of expr. MAX() may take a string argument; in such cases, it returns the maximum string value.
     *
     * @param IColumn $column
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_max
     * @see https://dev.mysql.com/doc/refman/5.7/en/mysql-indexes.html
     */
    public static function max(IColumn $column) {
        // "DISTINCT" is not supported as it produces the same result
        return new SimpleFunc('MAX',$column);
    }

    /**
     * Returns the minimum value of expr. MIN() may take a string argument; in such cases, it returns the minimum string value.
     *
     * @param IColumn $column
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_max
     * @see https://dev.mysql.com/doc/refman/5.7/en/mysql-indexes.html
     */
    public static function min(IColumn $column) {
        return new SimpleFunc('MIN',$column);
    }

    // how to do GroupConcat? Do we need a custom object?

    // todo: add countAll(), countDistinct(), countNotNull() etc
}