<?php namespace QueryBuilder\MySql\Functions;

use QueryBuilder\Functions\SimpleFunc;
use QueryBuilder\IExpr;
use QueryBuilder\IValue;
use QueryBuilder\Operator\Add;
use QueryBuilder\Operator\Mult;
use QueryBuilder\Operator\Sub;

abstract class Math {

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
    public static function atan(IExpr $y, IExpr $x = null) {
        if(func_num_args() >= 2) {
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

    /**
     * Returns the smallest integer value not less than X.
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_ceiling
     */
    public static function ceil(IExpr $x) {
        return new SimpleFunc('CEILING', $x);
    }

    /**
     * Converts numbers between different number bases. Returns a string representation of the number N, converted from base from_base to base to_base. Returns NULL if any argument is NULL. The argument N is interpreted as an integer, but may be specified as an integer or a string. The minimum base is 2 and the maximum base is 36. If to_base is a negative number, N is regarded as a signed number. Otherwise, N is treated as unsigned. CONV() works with 64-bit precision.
     *
     * @param IExpr $N
     * @param \QueryBuilder\IExpr $from_base
     * @param \QueryBuilder\IExpr $to_base
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_conv
     */
    public static function conv(IExpr $N, IExpr $from_base, IExpr $to_base) {
        return new SimpleFunc('CONV', $N, $from_base, $to_base);
    }

    /**
     * Returns the cosine of X, where X is given in radians.
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_cos
     */
    public static function cos(IExpr $x) {
        return new SimpleFunc('COS', $x);
    }

    /**
     * Returns the cotangent of X.
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_cot
     */
    public static function cot(IExpr $x) {
        return new SimpleFunc('COT', $x);
    }

    /**
     * Computes a cyclic redundancy check value and returns a 32-bit unsigned value. The result is NULL if the argument is NULL. The argument is expected to be a string and (if possible) is treated as one if it is not.
     *
     * @param IExpr $expr
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_crc32
     */
    public static function crc32(IExpr $expr) {
        return new SimpleFunc('CRC32', $expr);
    }

    /**
     * Returns the argument X, converted from radians to degrees.
     *
     * @param IExpr $expr
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_degrees
     */
    public static function degrees(IExpr $expr) {
        return new SimpleFunc('DEGREES', $expr);
    }

    /**
     * Returns the value of e (the base of natural logarithms) raised to the power of X. The inverse of this function is LOG() (using a single argument only) or LN().
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_exp
     */
    public static function exp(IExpr $x) {
        return new SimpleFunc('EXP', $x);
    }

    /**
     * Returns the largest integer value not greater than X.
     *
     * For exact-value numeric arguments, the return value has an exact-value numeric type. For string or floating-point arguments, the return value has a floating-point type.
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_floor
     */
    public static function floor(IExpr $x) {
        return new SimpleFunc('FLOOR', $x);
    }

    /**
     * Formats the number X to a format like '#,###,###.##', rounded to D decimal places, and returns the result as a string. If D is 0, the result has no decimal point or fractional part.
     *
     * The optional third parameter enables a locale to be specified to be used for the result number's decimal point, thousands separator, and grouping between separators. Permissible locale values are the same as the legal values for the lc_time_names system variable (see Section 10.7, �MySQL Server Locale Support�). If no locale is specified, the default is 'en_US'.
     *
     * @param \QueryBuilder\IExpr $x      Number to format
     * @param \QueryBuilder\IExpr $d      Decimal places
     * @param \QueryBuilder\IExpr $locale Locale used for the result number's decimal point, thousands separator, and grouping between separators. Defaults to 'en_US'.
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_format
     */
    public static function format(IExpr $x, IExpr $d, IExpr $locale = null) {
        return Str::format(...func_get_args());
    }


    /**
     * Returns a hexadecimal string representation of the value of N treated as a longlong (BIGINT) number. This is equivalent to CONV(N,10,16). The inverse of this operation is performed by CONV(HEX(N),16,10).
     *
     * @param \QueryBuilder\IExpr $n
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_hex
     */
    public static function hex(IExpr $n) {
        return Str::hex(...func_get_args());
    }

    /**
     * Returns the natural logarithm of X; that is, the base-e logarithm of X. If X is less than or equal to 0.0E0, the function returns NULL and (as of MySQL 5.7.4) a warning �Invalid argument for logarithm� is reported.
     *
     * This function is synonymous with LOG(X). The inverse of this function is the EXP() function.
     *
     * @param \QueryBuilder\IExpr $n
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_ln
     */
    public static function ln(IExpr $n) {
        return new SimpleFunc('LN', $n);
    }

    /**
     * If called with one parameter, this function returns the natural logarithm of X. If X is less than or equal to 0.0E0, the function returns NULL and (as of MySQL 5.7.4) a warning �Invalid argument for logarithm� is reported.
     *
     * The inverse of this function (when called with a single argument) is the EXP() function.
     *
     * If called with two parameters, this function returns the logarithm of X to the base B. If X is less than or equal to 0, or if B is less than or equal to 1, then NULL is returned.
     *
     * @param \QueryBuilder\IExpr $b
     * @param \QueryBuilder\IExpr $x
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_log
     */
    public static function log(IExpr $b, IExpr $x = null) {
        if(func_num_args() >= 2) {
            return new SimpleFunc('LOG', $b, $x);
        }
        return new SimpleFunc('LOG', $b);
    }

    /**
     * Returns the base-10 logarithm of X. If X is less than or equal to 0.0E0, the function returns NULL and (as of MySQL 5.7.4) a warning �Invalid argument for logarithm� is reported.
     *
     * @param \QueryBuilder\IExpr $x
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_log10
     */
    public static function log10(IExpr $x) {
        return new SimpleFunc('LOG10', $x);
    }

    /**
     * Returns the base-2 logarithm of X. If X is less than or equal to 0.0E0, the function returns NULL and (as of MySQL 5.7.4) a warning �Invalid argument for logarithm� is reported.
     *
     * LOG2() is useful for finding out how many bits a number requires for storage. This function is equivalent to the expression LOG(X) / LOG(2).
     *
     * @param \QueryBuilder\IExpr $x
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_log2
     */
    public static function log2(IExpr $x) {
        return new SimpleFunc('LOG2', $x);
    }

    /**
     * Modulo operation. Returns the remainder of N divided by M.
     *
     * This function is safe to use with BIGINT values.
     *
     * MOD() also works on values that have a fractional part and returns the exact remainder after division.
     *
     * MOD(N,0) returns NULL.
     *
     * @param \QueryBuilder\IExpr $n
     * @param \QueryBuilder\IExpr $m
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_mod
     */
    public static function mod(IExpr $n, IExpr $m) {
        return new SimpleFunc('MOD', $n, $m);
    }

    /**
     * Returns the value of ? (pi). The default number of decimal places displayed is seven, but MySQL uses the full double-precision value internally.
     *
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_pi
     */
    public static function pi() {
        return new SimpleFunc('PI');
    }

    /**
     * Returns the value of X raised to the power of Y.
     *
     * @param \QueryBuilder\IExpr $x
     * @param \QueryBuilder\IExpr $y
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_pow
     */
    public static function pow(IExpr $x, IExpr $y) {
        return new SimpleFunc('POW', $x, $y);
    }

    /**
     * Returns the argument X, converted from degrees to radians. (Note that ? radians equals 180 degrees.)
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_radians
     */
    public static function radians(IExpr $x) {
        return new SimpleFunc('RADIANS', $x);
    }

    /**
     * Returns a random floating-point value v in the range 0 <= v < 1.0. If a constant integer argument N is specified, it is used as the seed value, which produces a repeatable sequence of column values. In the following example, note that the sequences of values produced by RAND(3) is the same both places where it occurs.
     *
     * With a constant initializer, the seed is initialized once when the statement is compiled, prior to execution. If a nonconstant initializer (such as a column name) is used as the argument, the seed is initialized with the value for each invocation of RAND(). (One implication of this is that for equal argument values, RAND() will return the same value each time.)
     *
     * @param IValue $n Seed value
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_rand
     */
    public static function rand(IValue $n = null) {
        if(func_num_args() >= 1) {
            return new SimpleFunc('RAND', $n);
        }
        return new SimpleFunc('RAND');
    }

    /**
     * Returns a random integer value R in the range i <= R < j.
     *
     * @param \QueryBuilder\IExpr $min   Minimum value (inclusive)
     * @param \QueryBuilder\IExpr $max   Maximum value (exclusive)
     * @param \QueryBuilder\IValue $seed Seed value (optional)
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_rand
     */
    public static function randInt(IExpr $min, IExpr $max, IValue $seed = null) {
        return self::floor(new Add($min, new Mult(func_num_args() >= 3 ? self::rand($seed) : self::rand(), new Sub($max, $min))));
    }

    /**
     * Rounds the argument X to D decimal places. The rounding algorithm depends on the data type of X. D defaults to 0 if not specified. D can be negative to cause D digits left of the decimal point of the value X to become zero.
     *
     * The return type is the same type as that of the first argument (assuming that it is integer, double, or decimal). This means that for an integer argument, the result is an integer (no decimal places).
     *
     * ROUND() uses the following rules depending on the type of the first argument:
     *
     *  - For exact-value numbers, ROUND() uses the �round half away from zero� or �round toward nearest� rule: A value with a fractional part of .5 or greater is rounded up to the next integer if positive or down to the next integer if negative. (In other words, it is rounded away from zero.) A value with a fractional part less than .5 is rounded down to the next integer if positive or up to the next integer if negative.
     *  - For approximate-value numbers, the result depends on the C library. On many systems, this means that ROUND() uses the "round to nearest even" rule: A value with any fractional part is rounded to the nearest even integer.
     *
     * @param IExpr $x
     * @param \QueryBuilder\IExpr $d
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_round
     * @see https://dev.mysql.com/doc/refman/5.7/en/precision-math.html
     */
    public static function round(IExpr $x, IExpr $d = null) {
        if(func_num_args() >= 2) {
            return new SimpleFunc('ROUND', $x, $d);
        }
        return new SimpleFunc('ROUND', $x);
    }

    /**
     * Returns the sign of the argument as -1, 0, or 1, depending on whether X is negative, zero, or positive.
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_sign
     */
    public static function sign(IExpr $x) {
        return new SimpleFunc('SIGN', $x);
    }

    /**
     * Returns the sine of X, where X is given in radians.
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_sin
     */
    public static function sin(IExpr $x) {
        return new SimpleFunc('SIN', $x);
    }

    /**
     * Returns the square root of a nonnegative number X.
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_sqrt
     */
    public static function sqrt(IExpr $x) {
        return new SimpleFunc('SQRT', $x);
    }

    /**
     * Returns the tangent of X, where X is given in radians.
     *
     * @param IExpr $x
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_tan
     */
    public static function tan(IExpr $x) {
        return new SimpleFunc('TAN', $x);
    }

    /**
     * Returns the number X, truncated to D decimal places. If D is 0, the result has no decimal point or fractional part. D can be negative to cause D digits left of the decimal point of the value X to become zero.
     *
     * All numbers are rounded toward zero.
     *
     * @param IExpr $x
     * @param \QueryBuilder\IExpr $d
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_truncate
     */
    public static function truncate(IExpr $x, IExpr $d) {
        return new SimpleFunc('TRUNCATE', $x, $d);
    }

}