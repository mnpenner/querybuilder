<?php namespace QueryBuilder\MySql\Functions;

use QueryBuilder\Interfaces\IField;
use QueryBuilder\UserFunc;
use QueryBuilder\Interfaces\IColumn;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IOrder;
use QueryBuilder\Interfaces\ISelect;
use QueryBuilder\Interfaces\IValue;
use QueryBuilder\Unsafe\RawExpr;
use QueryBuilder\Unsafe\RawExprChain;
use QueryBuilder\StringLiteral;
use QueryBuilder\Value;

/**
 * Aggregate functions
 * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html
 */
abstract class Agg {


    /**
     * Returns the average value of expr. The DISTINCT option can be used to return the average of the distinct values of expr.
     *
     * AVG() returns NULL if there were no matching rows.
     *
     * @param IField $expr
     * @param bool $distinct
     * @return IExpr
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_avg
     */
    public static function avg(IField $expr, $distinct = false) {
        $chain = new RawExprChain('', 'AVG(');
        if($distinct) $chain->append('DISTINCT ');
        return $chain->append($expr->getExpr(), ')');
    }

    /**
     * Returns the bitwise AND of all bits in expr. The calculation is performed with 64-bit (BIGINT) precision.
     *
     * This function returns 18446744073709551615 if there were no matching rows. (This is the value of an unsigned BIGINT value with all bits set to 1.)
     *
     * @param IField $expr
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_bit-and
     */
    public static function bitAnd(IField $expr) {
        return new UserFunc('BIT_AND', $expr);
    }

    /**
     * Returns the bitwise OR of all bits in expr. The calculation is performed with 64-bit (BIGINT) precision.
     *
     * This function returns 0 if there were no matching rows.
     *
     * @param IField $expr
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_bit-or
     */
    public static function bitOr(IField $expr) {
        return new UserFunc('BIT_OR', $expr);
    }

    /**
     * Returns the bitwise XOR of all bits in expr. The calculation is performed with 64-bit (BIGINT) precision.
     *
     * This function returns 0 if there were no matching rows.
     *
     * @param IField $expr
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_bit-xor
     */
    public static function bitXor(IField $expr) {
        return new UserFunc('BIT_XOR', $expr);
    }

    /**
     * Returns a count of the number of rows with different non-NULL expr values.
     *
     * COUNT(DISTINCT) returns 0 if there were no matching rows.
     *
     * In MySQL, you can obtain the number of distinct expression combinations that do not contain NULL by giving a list of expressions. In standard SQL, you would have to do a concatenation of all expressions inside COUNT(DISTINCT ...).
     *
     * @param IColumn[] ...$cols
     * @return RawExprChain
     * @return https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_count-distinct
     */
    public static function countDistinct(IColumn ...$cols) {
        return new RawExprChain('', 'COUNT(DISTINCT ', new RawExprChain(', ', ...$cols), ')');
    }

    /**
     * Returns a count of the number of non-NULL values of `col` in the rows retrieved by a SELECT statement. The result is a BIGINT value.
     *
     * Returns 0 if there were no matching rows.
     *
     * @param IColumn $col
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_count
     */
    public static function countNonNull(IColumn $col) {
        return new UserFunc('COUNT', $col);
    }

    /**
     * Returns a count of the number of rows retrieved, whether or not they contain NULL values.
     *
     * Optimized to return very quickly if the SELECT retrieves from one table, no other columns are retrieved, and there is no WHERE clause.
     *
     * @return RawExpr
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_count
     */
    public static function countRows() {
        return new RawExpr('COUNT(*)');
    }

    /**
     * @param ISelect $select
     * @return IExpr
     */
    public static function exists(ISelect $select) {
        return new RawExprChain('', 'EXISTS(', $select, ')');
    }

    /**
     * Returns the maximum value of expr. MAX() may take a string argument; in such cases, it returns the maximum string value.
     *
     * @param IColumn $column
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_max
     * @see https://dev.mysql.com/doc/refman/5.7/en/mysql-indexes.html
     */
    public static function max(IColumn $column) {
        // "DISTINCT" is not supported as it produces the same result
        return new UserFunc('MAX', $column);
    }

    /**
     * Returns the minimum value of expr. MIN() may take a string argument; in such cases, it returns the minimum string value.
     *
     * @param IColumn $column
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_max
     * @see https://dev.mysql.com/doc/refman/5.7/en/mysql-indexes.html
     */
    public static function min(IColumn $column) {
        return new UserFunc('MIN', $column);
    }

    /**
     * Returns the sum of expr. If the return set has no rows, SUM() returns NULL. The DISTINCT keyword can be used to sum only the distinct values of expr.
     *
     * SUM() returns NULL if there were no matching rows.
     *
     * @param IField $expr
     * @param bool $distinct
     * @return IExpr
     */
    public static function sum(IField $expr, $distinct = false) {
        $chain = new RawExprChain('', 'SUM(');
        if($distinct) $chain->append('DISTINCT ');
        return $chain->append($expr->getExpr(), ')');
    }

    /**
     * This function returns a string result with the concatenated non-NULL values from a group. It returns NULL if there are no non-NULL values.
     *
     * @param IField[] $fields
     * @param bool $distinct
     * @param IOrder[] $orderBy
     * @param null|string $separator
     * @return IExpr
     * @throws \Exception
     */
    public static function groupConcat(array $fields, $distinct=false, array $orderBy=[], $separator=null) {
        $chain = new RawExprChain('', 'GROUP_CONCAT(');
        if($distinct) {
            $chain->append('DISTINCT ');
        }
        $exprs = [];
        foreach($fields as $f) {
            if(!($f instanceof IField)) {
                throw new \Exception("All fields must be an instance of ".IField::class);
            }
            $exprs[] = $f->getExpr();
        }
        $chain->append(new RawExprChain(', ', ...$exprs));
        if($orderBy) {
            $chain->append(' ORDER BY ', ...$orderBy);
        }
        if($separator !== null) {
            $chain->append(' SEPARATOR ', new Value((string)$separator)); // MySQL will *not* accept a column name here, nor a number, nor their weird _latin1'string' syntax here -- it has to be a simple quoted string.
        }
        return $chain->append(')');
    }

    // how to do GroupConcat? Do we need a custom object?
}