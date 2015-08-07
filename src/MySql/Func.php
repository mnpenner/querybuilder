<?php namespace QueryBuilder\MySql;

use QueryBuilder\Functions\SimpleFunc;
use QueryBuilder\IExpr;

abstract class Func {

    /**
     * Returns the absolute value of X.
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_abs
     */
    public static function abs(IExpr $x) {
        return new SimpleFunc('ABS', $x);
    }

    /**
     * Returns the arc cosine of X, that is, the value whose cosine is X. Returns NULL if X is not in the range -1 to 1.
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_acos
     */
    public static function acos(IExpr $x) {
        return new SimpleFunc('ACOS', $x);
    }

    /**
     * Returns the arc sine of X, that is, the value whose sine is X. Returns NULL if X is not in the range -1 to 1.
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_asin
     */
    public static function asin(IExpr $x) {
        return new SimpleFunc('ASIN', $x);
    }

    /**
     * Returns the arc tangent of X, that is, the value whose tangent is X.
     *
     * @param IExpr $y
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_atan
     */
    public static function atan(IExpr $y, IExpr $x=null) {
        if($x) {
            return new SimpleFunc('ATAN', $y, $x);
        }
        return new SimpleFunc('ATAN', $y);
    }

    /**
     * Returns the arc tangent of the two variables X and Y. It is similar to calculating the arc tangent of Y / X, except that the signs of both arguments are used to determine the quadrant of the result.
     *
     * @param IExpr $y
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_asin
     */
    public static function atan2(IExpr $y, IExpr $x) {
        return new SimpleFunc('ATAN2', $y, $x);
    }
}