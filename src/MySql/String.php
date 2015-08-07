<?php namespace QueryBuilder\MySql;

use QueryBuilder\Functions\SimpleFunc;
use QueryBuilder\IExpr;

abstract class String {


    /**
     * Formats the number X to a format like '#,###,###.##', rounded to D decimal places, and returns the result as a string. If D is 0, the result has no decimal point or fractional part.
     *
     * The optional third parameter enables a locale to be specified to be used for the result number's decimal point, thousands separator, and grouping between separators. Permissible locale values are the same as the legal values for the lc_time_names system variable (see Section 10.7, “MySQL Server Locale Support”). If no locale is specified, the default is 'en_US'.
     *
     * @param \QueryBuilder\IExpr $x Number to format
     * @param \QueryBuilder\IExpr $d Decimal places
     * @param \QueryBuilder\IExpr $locale Locale used for the result number's decimal point, thousands separator, and grouping between separators. Defaults to 'en_US'.
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_format
     */
    public static function format(IExpr $x, IExpr $d, IExpr $locale=null) {
        if(func_num_args() >= 3) {
            return new SimpleFunc('FORMAT', $x, $d, $locale);
        }
        return new SimpleFunc('FORMAT', $x, $d);
    }

    /**
     * Returns a hexadecimal string representation of str where each byte of each character in str is converted to two hexadecimal digits. (Multibyte characters therefore become more than two digits.) The inverse of this operation is performed by the UNHEX() function.
     *
     * @param \QueryBuilder\IExpr $str
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_hex
     * @see unhex
     */
    public static function hex(IExpr $str) {
        return new SimpleFunc('HEX', $str);
    }

    /**
     * For a string argument str, UNHEX(str) interprets each pair of characters in the argument as a hexadecimal number and converts it to the byte represented by the number. The return value is a binary string.
     *
     * The characters in the argument string must be legal hexadecimal digits: '0' .. '9', 'A' .. 'F', 'a' .. 'f'. If the argument contains any nonhexadecimal digits, the result is NULL.
     *
     * A NULL result can occur if the argument to UNHEX() is a BINARY column, because values are padded with 0x00 bytes when stored but those bytes are not stripped on retrieval. For example, '41' is stored into a CHAR(3) column as '41 ' and retrieved as '41' (with the trailing pad space stripped), so UNHEX() for the column value returns 'A'. By contrast '41' is stored into a BINARY(3) column as '41\0' and retrieved as '41\0' (with the trailing pad 0x00 byte not stripped). '\0' is not a legal hexadecimal digit, so UNHEX() for the column value returns NULL.
     *
     * For a numeric argument N, the inverse of HEX(N) is not performed by UNHEX(). Use CONV(HEX(N),16,10) instead. See the description of HEX().
     *
     * @param \QueryBuilder\IExpr $str
     * @return \QueryBuilder\Functions\SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_unhex
     * @see hex
     */
    public static function unhex(IExpr $str) {
        return new SimpleFunc('UNHEX', $str);
    }
}