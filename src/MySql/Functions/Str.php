<?php namespace QueryBuilder\MySql\Functions;

use QueryBuilder\Interfaces\IExpressionable;
use QueryBuilder\UserFunc;
use QueryBuilder\Interfaces\ICharset;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Unsafe\RawExprChain;
use QueryBuilder\Util;

abstract class Str {

    /**
     * Return numeric value of left-most character.
     *
     * Returns the numeric value of the leftmost character of the string str. Returns 0 if str is the empty string. Returns NULL if str is NULL. ASCII() works for 8-bit characters.
     *
     * @param IExpressionable $str
     * @return \QueryBuilder\UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_ascii
     * @see ord
     */
    public static function ascii(IExpressionable $str) {
        return new UserFunc('ASCII', $str);
    }

    /**
     * Return a string containing binary representation of a number
     *
     * Returns a string representation of the binary value of N, where N is a longlong (BIGINT) number. This is equivalent to CONV(N,10,2). Returns NULL if N is NULL.
     *
     * @param IExpressionable $n
     * @return \QueryBuilder\UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_bin
     */
    public static function bin(IExpressionable $n) {
        return new UserFunc('BIN', $n);
    }

    /**
     * Returns the length of the string str in bits.
     *
     * @param IExpressionable $n
     * @return \QueryBuilder\UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_bit-length
     */
    public static function bitLength(IExpressionable $n) {
        return new UserFunc('BIT_LENGTH', $n);
    }

    /**
     * Return the character for each integer passed.
     *
     * CHAR() interprets each argument N as an integer and returns a string consisting of the characters given by the code values of those integers. NULL values are skipped.
     *
     * CHAR() arguments larger than 255 are converted into multiple result bytes. For example, CHAR(256) is equivalent to CHAR(1,0), and CHAR(256*256) is equivalent to CHAR(1,0,0).
     *
     * By default, CHAR() returns a binary string. To produce a string in a given character set, use the optional USING clause.
     *
     * @param IExpressionable[] $n
     * @return \QueryBuilder\UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_char
     */
    public static function char(IExpressionable... $n) {
        return new UserFunc('CHAR', ...$n);
    }

    /**
     * Return number of characters in argument
     *
     * Returns the length of the string str, measured in characters. A multibyte character counts as a single character. This means that for a string containing five 2-byte characters, LENGTH() returns 10, whereas CHAR_LENGTH() returns 5.
     *
     * @param IExpressionable $str
     * @return UserFunc Number of characters in argument
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_char-length
     */
    public static function charLength(IExpressionable $str) {
        return new UserFunc('CHAR_LENGTH', $str);
    }

    /**
     * Return the character for each integer passed.
     *
     * CHAR() interprets each argument N as an integer and returns a string consisting of the characters given by the code values of those integers. NULL values are skipped.
     *
     * CHAR() arguments larger than 255 are converted into multiple result bytes. For example, CHAR(256) is equivalent to CHAR(1,0), and CHAR(256*256) is equivalent to CHAR(1,0,0).
     *
     * If the result string is illegal for the given character set, a warning is issued. Also, if strict SQL mode is enabled, the result from CHAR() becomes NULL.
     *
     * @param ICharset $charset
     * @param IExpr[] ...$n
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_char
     * @return RawExprChain
     */
    public static function charUsing(ICharset $charset, IExpr... $n) {
        return new RawExprChain('', 'CHAR(', new RawExprChain(', ', ...$n), ' USING ', $charset, ')');
    }

    /**
     * Returns the string that results from concatenating the arguments. May have one or more arguments. If all arguments are nonbinary strings, the result is a nonbinary string. If the arguments include any binary strings, the result is a binary string. A numeric argument is converted to its equivalent nonbinary string form.
     *
     * CONCAT() returns NULL if any argument is NULL.
     *
     * @param IExpressionable[] ...$str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_concat
     */
    public static function concat(IExpressionable ...$str) {
        return new UserFunc('CONCAT', ...$str);
    }

    /**
     * Return concatenate with separator
     *
     * CONCAT_WS() stands for Concatenate With Separator and is a special form of CONCAT(). The first argument is the separator for the rest of the arguments. The separator is added between the strings to be concatenated. The separator can be a string, as can the rest of the arguments. If the separator is NULL, the result is NULL.
     *
     * CONCAT_WS() does not skip empty strings. However, it does skip any NULL values after the separator argument.
     *
     * @param IExpressionable $separator
     * @param IExpressionable[] $strings
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_concat-ws
     */
    public static function concatWS(IExpressionable $separator, IExpressionable... $strings) {
        return new UserFunc('CONCAT_WS', $separator, ...$strings);
    }

    /**
     * Return string at index number
     *
     * ELT() returns the Nth element of the list of strings: str1 if N = 1, str2 if N = 2, and so on. Returns NULL if N is less than 1 or greater than the number of arguments. ELT() is the complement of FIELD().
     *
     * @param IExpressionable $N
     * @param IExpressionable[] $str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_elt
     */
    public static function elt(IExpressionable $N, IExpressionable... $str) {
        return new UserFunc('ELT', $N, ...$str);
    }

    /**
     * Return a string such that for every bit set in the value bits, you get an on string and for every unset bit, you get an off string
     *
     * Returns a string such that for every bit set in the value bits, you get an on string and for every bit not set in the value, you get an off string. Bits in bits are examined from right to left (from low-order to high-order bits). Strings are added to the result from left to right, separated by the separator string (the default being the comma character “,”). The number of bits examined is given by number_of_bits, which has a default of 64 if not specified. number_of_bits is silently clipped to 64 if larger than 64. It is treated as an unsigned integer, so a value of −1 is effectively the same as 64.
     *
     * @param IExpressionable $bits
     * @param IExpressionable $on
     * @param IExpressionable $off
     * @param IExpressionable|null $separator
     * @param IExpressionable|null $numberOfBits
     * @return UserFunc
     * @throws \Exception
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_export-set
     */
    public static function exportSet(IExpressionable $bits, IExpressionable $on, IExpressionable $off, IExpressionable $separator = null, IExpr $numberOfBits = null) {
        switch(func_num_args()) {
            case 3:
                return new UserFunc('EXPORT_SET', $bits, $on, $off);
            case 4:
                return new UserFunc('EXPORT_SET', $bits, $on, $off, $separator);
            case 5:
                return new UserFunc('EXPORT_SET', $bits, $on, $off, $separator, $numberOfBits);
        }
        throw new \Exception("Incorrect number of arguments");
    }

    /**
     * Return the index (position) of the first argument in the subsequent arguments
     *
     * Returns the index (position) of str in the str1, str2, str3, ... list. Returns 0 if str is not found.
     *
     * If all arguments to FIELD() are strings, all arguments are compared as strings. If all arguments are numbers, they are compared as numbers. Otherwise, the arguments are compared as double.
     *
     * If str is NULL, the return value is 0 because NULL fails equality comparison with any value. FIELD() is the complement of ELT().
     *
     * @param IExpressionable $field
     * @param IExpressionable[] ...$str1
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_field
     * @return UserFunc
     */
    public static function field(IExpressionable $field, IExpressionable... $str1) {
        return new UserFunc('FIELD', $field, ...$str1);
    }

    /**
     * Return the index position of the first argument within the second argument
     *
     * Returns a value in the range of 1 to N if the string str is in the string list strlist consisting of N substrings. A string list is a string composed of substrings separated by “,” characters. If the first argument is a constant string and the second is a column of type SET, the FIND_IN_SET() function is optimized to use bit arithmetic. Returns 0 if str is not in strlist or if strlist is the empty string. Returns NULL if either argument is NULL. This function does not work properly if the first argument contains a comma (“,”) character.
     *
     * @param IExpressionable $str
     * @param IExpressionable $strlist
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_find-in-set
     */
    public static function findInSet(IExpressionable $str, IExpressionable $strlist) {
        return new UserFunc('FIND_IN_SET', $str, $strlist);
    }

    /**
     * Return a number formatted to specified number of decimal places.
     *
     * Formats the number X to a format like '#,###,###.##', rounded to D decimal places, and returns the result as a string. If D is 0, the result has no decimal point or fractional part.
     *
     * The optional third parameter enables a locale to be specified to be used for the result number's decimal point, thousands separator, and grouping between separators. Permissible locale values are the same as the legal values for the lc_time_names system variable (see Section 10.7, �MySQL Server Locale Support�). If no locale is specified, the default is 'en_US'.
     *
     * @param IExpressionable $x      Number to format
     * @param IExpressionable $d      Decimal places
     * @param IExpressionable $locale Locale used for the result number's decimal point, thousands separator, and grouping between separators. Defaults to 'en_US'.
     * @return \QueryBuilder\UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_format
     */
    public static function format(IExpressionable $x, IExpressionable $d, IExpressionable $locale = null) {
        if(func_num_args() >= 3) {
            return new UserFunc('FORMAT', $x, $d, $locale);
        }
        return new UserFunc('FORMAT', $x, $d);
    }

    /**
     * Decode to a base-64 string and return result
     *
     * Takes a string encoded with the base-64 encoded rules used by TO_BASE64() and returns the decoded result as a binary string. The result is NULL if the argument is NULL or not a valid base-64 string. See the description of TO_BASE64() for details about the encoding and decoding rules.
     *
     * @param IExpressionable $str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_from-base64
     */
    public static function fromBase64(IExpressionable $str) {
        return new UserFunc('FROM_BASE64', $str);
    }

    /**
     * Return a hexadecimal representation of a decimal or string value.
     *
     * Returns a hexadecimal string representation of str where each byte of each character in str is converted to two hexadecimal digits. (Multibyte characters therefore become more than two digits.) The inverse of this operation is performed by the UNHEX() function.
     *
     * @param IExpressionable $str
     * @return \QueryBuilder\UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_hex
     * @see unhex
     */
    public static function hex(IExpressionable $str) {
        return new UserFunc('HEX', $str);
    }

    /**
     * Return the index of the first occurrence of substring
     *
     * Returns the position of the first occurrence of substring substr in string str. This is the same as the two-argument form of LOCATE(), except that the order of the arguments is reversed.
     *
     * @param IExpressionable $str
     * @param IExpressionable $substr
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_instr
     */
    public static function inStr(IExpressionable $str, IExpressionable $substr) {
        return new UserFunc('INSTR', $str, $substr);
    }

    /**
     * Insert a substring at the specified position up to the specified number of characters
     *
     * Returns the string str, with the substring beginning at position pos and len characters long replaced by the string newstr. Returns the original string if pos is not within the length of the string. Replaces the rest of the string from position pos if len is not within the length of the rest of the string. Returns NULL if any argument is NULL.
     *
     * @param IExpressionable $str
     * @param IExpressionable $pos
     * @param IExpressionable $len
     * @param IExpressionable $newlen
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_insert
     */
    public static function insert(IExpressionable $str, IExpressionable $pos, IExpressionable $len, IExpressionable $newlen) {
        return new UserFunc('INSERT', $str, $pos, $len, $newlen);
    }

    /**
     * Return the leftmost number of characters as specified
     *
     * Returns the leftmost len characters from the string str, or NULL if any argument is NULL.
     *
     * @param IExpressionable $str
     * @param IExpressionable $len
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_left
     */
    public static function left(IExpressionable $str, IExpressionable $len) {
        return new UserFunc('LEFT', $str, $len);
    }

    /**
     * Return the length of a string in bytes
     *
     * Returns the length of the string str, measured in bytes. A multibyte character counts as multiple bytes. This means that for a string containing five 2-byte characters, LENGTH() returns 10, whereas CHAR_LENGTH() returns 5.
     *
     * @param IExpressionable $str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_length
     */
    public static function length(IExpressionable $str) {
        return new UserFunc('LENGTH', $str);
    }

    /**
     * Load the named file
     *
     * Reads the file and returns the file contents as a string. To use this function, the file must be located on the server host, you must specify the full path name to the file, and you must have the FILE privilege. The file must be readable by all and its size less than max_allowed_packet bytes. If the secure_file_priv system variable is set to a nonempty directory name, the file to be loaded must be located in that directory.
     *
     * If the file does not exist or cannot be read because one of the preceding conditions is not satisfied, the function returns NULL.
     *
     * The character_set_filesystem system variable controls interpretation of file names that are given as literal strings.
     *
     * @param IExpressionable $fileName
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_load-file
     */
    public static function loadFile(IExpressionable $fileName) {
        return new UserFunc('LOAD_FILE', $fileName);
    }

    /**
     * Return the position of the first occurrence of substring
     *
     * Returns the position of the first occurrence of substring substr in string str. If `pos` is provided, searching will begin at that position. Returns 0 if substr is not in str.
     *
     * This function is multibyte safe, and is case-sensitive only if at least one argument is a binary string.
     *
     * @param IExpressionable $substr
     * @param IExpressionable $str
     * @param IExpressionable $pos
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_locate
     */
    public static function locate(IExpressionable $substr, IExpressionable $str, IExpressionable $pos) {
        if(func_num_args() >= 3) {
            return new UserFunc('LOCATE', $substr, $str, $pos);
        }
        return new UserFunc('LOCATE', $substr, $str);
    }

    /**
     * Return the argument in lowercase
     *
     * Returns the string str with all characters changed to lowercase according to the current character set mapping. The default is latin1 (cp1252 West European).
     *
     * LOWER() (and UPPER()) are ineffective when applied to binary strings (BINARY, VARBINARY, BLOB). To perform lettercase conversion, convert the string to a nonbinary string.
     *
     * For Unicode character sets, LOWER() and UPPER() work accounting to Unicode Collation Algorithm (UCA) 5.2.0 for xxx_unicode_520_ci collations and for language-specific collations that are derived from them. For other Unicode collations, LOWER() and UPPER() work accounting to Unicode Collation Algorithm (UCA) 4.0.0. See Section 10.1.14.1, “Unicode Character Sets”.
     *
     * This function is multibyte safe.
     *
     * In previous versions of MySQL, LOWER() used within a view was rewritten as LCASE() when storing the view's definition. In MySQL 5.7, LOWER() is never rewritten in such cases, but LCASE() used within views is instead rewritten as LOWER(). (Bug #12844279)
     *
     * @param IExpressionable $str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_lower
     */
    public static function lower(IExpressionable $str) {
        return new UserFunc('LOWER', $str);
    }

    /**
     * Return the string argument, left-padded with the specified string
     *
     * Returns the string str, left-padded with the string padstr to a length of len characters. If str is longer than len, the return value is shortened to len characters.
     *
     * @param IExpressionable $str
     * @param IExpressionable $len
     * @param IExpressionable $padstr
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_lpad
     * @return UserFunc
     */
    public static function lpad(IExpressionable $str, IExpressionable $len, IExpressionable $padstr) {
        return new UserFunc('LPAD', $str, $len, $padstr);
    }

    /**
     * Returns the string str with leading space characters removed.
     *
     * @param IExpressionable $str
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_ltrim
     * @return UserFunc
     */
    public static function ltrim(IExpressionable $str) {
        return new UserFunc('LTRIM', $str);
    }

    /**
     * Return a set of comma-separated strings that have the corresponding bit in bits set
     *
     * Returns a set value (a string containing substrings separated by “,” characters) consisting of the strings that have the corresponding bit in bits set. str1 corresponds to bit 0, str2 to bit 1, and so on. NULL values in str1, str2, ... are not appended to the result.
     *
     * @param IExpressionable $bits
     * @param IExpressionable[] $str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_make-set
     */
    public static function makeSet(IExpressionable $bits, IExpressionable... $str) {
        return new UserFunc('MAKE_SET', $bits, ...$str);
    }

    /**
     * Synonym for substring.
     *
     * @param IExpressionable $str
     * @param IExpressionable $pos
     * @param IExpressionable $len
     * @see substring
     * @return UserFunc
     * @deprecated
     */
    public static function mid(IExpressionable $str, IExpressionable $pos, IExpressionable $len = null) {
        if(func_num_args() >= 3) {
            return new UserFunc('MID', $str, $pos, $len);
        }
        return new UserFunc('MID', $str, $pos);
    }

    /**
     * Returns a string representation of the octal value of N, where N is a longlong (BIGINT) number. This is equivalent to CONV(N,10,8). Returns NULL if N is NULL.
     *
     * @param IExpressionable $n
     * @return UserFunc
     */
    public static function oct(IExpressionable $n) {
        return new UserFunc('OCT', $n);
    }

    /**
     * If the leftmost character of the string str is a multibyte character, returns the code for that character, calculated from the numeric values of its constituent bytes using this formula:
     *
     *   (1st byte code)
     * + (2nd byte code * 256)
     * + (3rd byte code * 256**2) ...
     *
     * If the leftmost character is not a multibyte character, ORD() returns the same value as the ASCII() function.
     *
     * @param IExpressionable $str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_ord
     */
    public static function ord(IExpressionable $str) {
        return new UserFunc('ORD', $str);
    }

    /**
     * Synonym for LOCATE(substr,str).
     *
     * @param IExpressionable $substr
     * @param IExpressionable $str
     * @return RawExprChain
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_position
     */
    public static function position(IExpressionable $substr, IExpressionable $str) {
        return new RawExprChain('POSITION(', $substr, ' IN ', $str, ')');
    }

    /**
     * Quotes a string to produce a result that can be used as a properly escaped data value in an SQL statement. The string is returned enclosed by single quotation marks and with each instance of backslash (“\”), single quote (“'”), ASCII NUL, and Control+Z preceded by a backslash. If the argument is NULL, the return value is the word “NULL” without enclosing single quotation marks.
     *
     * @param IExpressionable $str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_quote
     */
    public static function quote(IExpressionable $str) {
        return new UserFunc('QUOTE', $str);
    }

    /**
     * Returns a string consisting of the string str repeated count times. If count is less than 1, returns an empty string. Returns NULL if str or count are NULL.
     *
     * @param IExpressionable $str
     * @param IExpressionable $count
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_repeat
     */
    public static function repeat(IExpressionable $str, IExpressionable $count) {
        return new UserFunc('REPEAT', $str, $count);
    }

    /**
     * Returns the string str with all occurrences of the string from_str replaced by the string to_str. REPLACE() performs a case-sensitive match when searching for from_str.
     *
     * @param IExpressionable $str
     * @param IExpressionable $from_str
     * @param IExpressionable $to_str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_replace
     */
    public static function replace(IExpressionable $str, IExpressionable $from_str, IExpressionable $to_str) {
        return new UserFunc('REPLACE', $str, $from_str, $to_str);
    }

    /**
     * Returns the string str with the order of the characters reversed.
     *
     * @param IExpressionable $str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_reverse
     */
    public static function reverse(IExpressionable $str) {
        return new UserFunc('REVERSE', $str);
    }

    /**
     * Return the rightmost number of characters as specified
     *
     * Returns the rightmost len characters from the string str, or NULL if any argument is NULL.
     *
     * @param IExpressionable $str
     * @param IExpressionable $len
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_right
     */
    public static function right(IExpressionable $str, IExpressionable $len) {
        return new UserFunc('RIGHT', $str, $len);
    }

    /**
     * Returns the string str, right-padded with the string padstr to a length of len characters. If str is longer than len, the return value is shortened to len characters.
     *
     * @param IExpressionable $str
     * @param IExpressionable $len
     * @param IExpressionable $padstr
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_rpad
     */
    public static function rpad(IExpressionable $str, IExpressionable $len, IExpressionable $padstr) {
        return new UserFunc('RPAD', $str, $len, $padstr);
    }

    /**
     * Returns the string str with trailing space characters removed.
     *
     * @param IExpressionable $str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_rtrim
     */
    public static function rtrim(IExpressionable $str) {
        return new UserFunc('RTRIM', $str);
    }

    /**
     * Returns a soundex string from str. Two strings that sound almost the same should have identical soundex strings. A standard soundex string is four characters long, but the SOUNDEX() function returns an arbitrarily long string. You can use SUBSTRING() on the result to get a standard soundex string. All nonalphabetic characters in str are ignored. All international alphabetic characters outside the A-Z range are treated as vowels.
     *
     * Important: When using SOUNDEX(), you should be aware of the following limitations:
     *
     * - This function, as currently implemented, is intended to work well with strings that are in the English language only. Strings in other languages may not produce reliable results.
     * - This function is not guaranteed to provide consistent results with strings that use multibyte character sets, including utf-8.
     *
     * Note:
     * This function implements the original Soundex algorithm, not the more popular enhanced version (also described by D. Knuth). The difference is that original version discards vowels first and duplicates second, whereas the enhanced version discards duplicates first and vowels second.
     *
     * @param IExpressionable $str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_soundex
     */
    public static function soundex(IExpressionable $str) {
        return new UserFunc('SOUNDEX', $str);
    }

    /**
     * Returns a string consisting of N space characters.
     *
     * @param IExpressionable $n
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_space
     */
    public static function space(IExpressionable $n) {
        return new UserFunc('SPACE', $n);
    }

    /**
     * The forms without a len argument return a substring from string str starting at position pos. The forms with a len argument return a substring len characters long from string str, starting at position pos. It is also possible to use a negative value for pos. In this case, the beginning of the substring is pos characters from the end of the string, rather than the beginning. A negative value may be used for pos in any of the forms of this function.
     *
     * For all forms of SUBSTRING(), the position of the first character in the string from which the substring is to be extracted is reckoned as 1.
     *
     * This function is multibyte safe.
     *
     * If len is less than 1, the result is the empty string.
     *
     * @param IExpressionable $str Subject string
     * @param IExpressionable $pos Starting position, 1-indexed
     * @param IExpressionable $len Length of substring
     * @return UserFunc
     */
    public static function substring(IExpressionable $str, IExpressionable $pos, IExpressionable $len = null) {
        if(func_num_args() >= 3) {
            return new UserFunc('SUBSTRING', $str, $pos, $len);
        }
        return new UserFunc('SUBSTRING', $str, $pos);
    }

    /**
     * Returns the substring from string str before count occurrences of the delimiter delim. If count is positive, everything to the left of the final delimiter (counting from the left) is returned. If count is negative, everything to the right of the final delimiter (counting from the right) is returned. SUBSTRING_INDEX() performs a case-sensitive match when searching for delim.
     *
     * This function is multibyte safe.
     *
     * @param IExpressionable $str
     * @param IExpressionable $delim
     * @param IExpressionable $count
     * @return UserFunc
     */
    public static function substringIndex(IExpressionable $str, IExpressionable $delim, IExpressionable $count) {
        return new UserFunc('SUBSTRING_INDEX', $str, $delim, $count);
    }

    /**
     * Converts the string argument to base-64 encoded form and returns the result as a character string with the connection character set and collation. If the argument is not a string, it is converted to a string before conversion takes place. The result is NULL if the argument is NULL. Base-64 encoded strings can be decoded using the FROM_BASE64() function.
     *
     * @param IExpressionable $str
     * @return UserFunc
     * @see from_base64
     */
    public static function toBase64(IExpressionable $str) {
        return new UserFunc('TO_BASE64', $str);
    }

    /**
     * Returns the string $str with all $remstr prefixes and suffixes removed.
     *
     * If $remstr is not specified, spaces are removed.
     *
     * This function is multibyte safe.
     *
     * @param IExpr $str
     * @param IExpr|null $remstr
     * @return RawExprChain
     */
    public static function trim(IExpr $str, IExpr $remstr = null) {
        $chain = new RawExprChain('', 'TRIM(');
        if(func_num_args() >= 2) {
            $chain->append('BOTH ', $remstr, ' FROM ');
        }
        $chain->append($str, ')');
        return $chain;
    }

    /**
     * Returns the string $str with all $remstr suffixes removed.
     *
     * This function is multibyte safe.
     *
     * @param IExpr $str
     * @param IExpr $remstr
     * @return RawExprChain
     */
    public static function trimLeading(IExpr $str, IExpr $remstr) {
        return new RawExprChain('', 'TRIM(LEADING ', $remstr, ' FROM ', $str, ')');
    }

    /**
     * Returns the string $str with all $remstr suffixes removed.
     *
     * This function is multibyte safe.
     *
     * @param IExpr $str
     * @param IExpr $remstr
     * @return RawExprChain
     */
    public static function trimTrailing(IExpr $str, IExpr $remstr) {
        return new RawExprChain('', 'TRIM(TRAILING ', $remstr, ' FROM ', $str, ')');
    }

    /**
     * Return a string containing hex representation of a number.
     *
     * For a string argument str, UNHEX(str) interprets each pair of characters in the argument as a hexadecimal number and converts it to the byte represented by the number. The return value is a binary string.
     *
     * The characters in the argument string must be legal hexadecimal digits: '0' .. '9', 'A' .. 'F', 'a' .. 'f'. If the argument contains any nonhexadecimal digits, the result is NULL.
     *
     * A NULL result can occur if the argument to UNHEX() is a BINARY column, because values are padded with 0x00 bytes when stored but those bytes are not stripped on retrieval. For example, '41' is stored into a CHAR(3) column as '41 ' and retrieved as '41' (with the trailing pad space stripped), so UNHEX() for the column value returns 'A'. By contrast '41' is stored into a BINARY(3) column as '41\0' and retrieved as '41\0' (with the trailing pad 0x00 byte not stripped). '\0' is not a legal hexadecimal digit, so UNHEX() for the column value returns NULL.
     *
     * For a numeric argument N, the inverse of HEX(N) is not performed by UNHEX(). Use CONV(HEX(N),16,10) instead. See the description of HEX().
     *
     * @param IExpressionable $str
     * @return \QueryBuilder\UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_unhex
     * @see hex
     */
    public static function unhex(IExpressionable $str) {
        return new UserFunc('UNHEX', $str);
    }

    /**
     * Return the argument in uppercase
     *
     * Returns the string str with all characters changed to uppercase according to the current character set mapping. The default is latin1 (cp1252 West European).
     *
     * See the description of LOWER() for information that also applies to UPPER(). This included information about how to perform lettercase conversion of binary strings (BINARY, VARBINARY, BLOB) for which these functions are ineffective, and information about case folding for Unicode character sets.
     *
     * This function is multibyte safe.
     *
     * In previous versions of MySQL, UPPER() used within a view was rewritten as UCASE() when storing the view's definition. In MySQL 5.7, UPPER() is never rewritten in such cases, but UCASE() used within views is instead rewritten as UPPER(). (Bug #12844279)
     *
     * @param IExpressionable $str
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_upper
     */
    public static function upper(IExpressionable $str) {
        return new UserFunc('UPPER', $str);
    }

    /**
     * This function returns the weight string for the input string. The return value is a binary string that represents the sorting and comparison value of the string.
     * It has these properties:
     *
     * - If WEIGHT_STRING(str1) = WEIGHT_STRING(str2), then str1 = str2 (str1 and str2 are considered equal)
     * - If WEIGHT_STRING(str1) < WEIGHT_STRING(str2), then str1 < str2 (str1 sorts before str2)
     *
     * WEIGHT_STRING() can be used for testing and debugging of collations, especially if you are adding a new collation.
     *
     * @param IExpr $str
     * @param string|null $type                      {CHAR|BINARY}(N)
     * @param string|array|\Traversable|null $levels May be given either as a list of one or more integers separated by commas, or as a range of two integers separated by a dash. Whitespace around the punctuation characters does not matter.
     * @return RawExprChain
     * @see https://dev.mysql.com/doc/refman/5.7/en/string-functions.html#function_weight-string
     */
    public static function weightString(IExpr $str, $type = null, $levels = null) {
        $chain = new RawExprChain('', 'WEIGHT_STRING(', $str);
        if($type !== null) {
            $chain->append(' AS ', $type); // fixme: this is a bit like an IDataType but not quite
        }
        if($levels !== null) {
            $chain->append(' LEVEL ', Util::joinIter(', ', $levels)); // fixme: this stupid thing doesn't follow any existing syntax, how can we sanitize it?
        }
        $chain->append(')');
        return $chain;
    }
}