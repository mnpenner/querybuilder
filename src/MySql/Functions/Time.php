<?php namespace QueryBuilder\MySql\Functions;

use QueryBuilder\Interfaces\IField;
use QueryBuilder\UserFunc;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IIntervalUnit;
use QueryBuilder\Interval;
use QueryBuilder\StringLiteral;
use QueryBuilder\SystemVariable;

abstract class Time {


    /**
     * Add time values (intervals) to a date value.
     *
     * @param IField $date         Specifies the starting date or datetime value
     * @param IField $value        Interval value to be added or subtracted from the starting date; it may be negative.
     * @param IIntervalUnit $unit Keyword indicating the units in which the expression should be interpreted.
     * @return UserFunc The return value depends on the arguments:
     *
     *                    - DATETIME if the first argument is a DATETIME (or TIMESTAMP) value, or if the first argument is a DATE and the unit value uses HOURS, MINUTES, or SECONDS.
     *                    - String otherwise.
     *
     *                    To ensure that the result is DATETIME, you can use CAST() to convert the first argument to DATETIME.
     * @see https://dev.mysql.com/doc/refman/5.7/en/date-and-time-functions.html#function_date-add
     */
    public static function dateAdd(IField $date, IField $value, IIntervalUnit $unit) {
        return new UserFunc('DATE_ADD', $date, new Interval($value, $unit));
    }

    /**
     * Subtract a time value (interval) from a date.
     *
     * @param IField $date         Specifies the starting date or datetime value
     * @param IField $value        Interval value to be added or subtracted from the starting date; it may be negative.
     * @param IIntervalUnit $unit Keyword indicating the units in which the expression should be interpreted.
     * @return UserFunc The return value depends on the arguments:
     *
     *                    - DATETIME if the first argument is a DATETIME (or TIMESTAMP) value, or if the first argument is a DATE and the unit value uses HOURS, MINUTES, or SECONDS.
     *                    - String otherwise.
     *
     *                    To ensure that the result is DATETIME, you can use CAST() to convert the first argument to DATETIME.
     * @see https://dev.mysql.com/doc/refman/5.7/en/date-and-time-functions.html#function_date-add
     */
    public static function dateSub(IField $date, IField $value, IIntervalUnit $unit) {
        return new UserFunc('DATE_SUB', $date, new Interval($value, $unit));
    }

    /**
     * CONVERT_TZ() converts a datetime value dt from the time zone given by from_tz to the time zone given by to_tz and returns the resulting value.
     *
     * This function returns NULL if the arguments are invalid.
     *
     * If the value falls out of the supported range of the TIMESTAMP type when converted from from_tz to UTC, no conversion occurs.
     *
     * Note:
     * To use named time zones such as 'MET' or 'Europe/Moscow', the time zone tables must be properly set up.
     *
     * @param IField $dt
     * @param IField $from_tz
     * @param IField $to_tz
     * @return UserFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/date-and-time-functions.html#function_convert-tz
     * @see https://dev.mysql.com/doc/refman/5.7/en/time-zone-support.html
     */
    public static function convertTZ(IField $dt, IField $from_tz, IField $to_tz) {
        return new UserFunc('CONVERT_TZ', $dt, $from_tz, $to_tz);
    }

    /**
     * Converts a unix timestamp to a MySQL datetime in the specified or current time zone.
     *
     * @param IField $unixtime Number of seconds since 1970-01-01 00:00:00 UTC
     * @param IField|null $timezone Defaults to @@session.time_zone
     * @return UserFunc
     * @deprecated Doesn't cover all scenarios
     */
    public static function unixToDateTime(IField $unixtime, IField $timezone=null) {
        if($timezone === null) $timezone = new SystemVariable('session.time_zone');
        return self::convertTZ(self::dateAdd(new StringLiteral('1970-01-01'), $unixtime, Interval::SECOND()), new StringLiteral('UTC'), $timezone);
    }

    /**
     * Returns a representation of the unix_timestamp argument as a value in 'YYYY-MM-DD HH:MM:SS' or YYYYMMDDHHMMSS format, depending on whether the function is used in a string or numeric context. The value is expressed in the current time zone. unix_timestamp is an internal timestamp value such as is produced by the UNIX_TIMESTAMP() function.
     *
     * If format is given, the result is formatted according to the format string, which is used the same way as listed in the entry for the DATE_FORMAT() function.
     *
     * Note: If you use UNIX_TIMESTAMP() and FROM_UNIXTIME() to convert between TIMESTAMP values and Unix timestamp values, the conversion is lossy because the mapping is not one-to-one in both directions. For details, see the description of the UNIX_TIMESTAMP() function.
     *
     * @param IField $unix_timestamp Number of seconds since 1970-01-01 00:00:00 UTC
     * @param IField|null $format Date format
     * @return UserFunc
     * @see unixTimestamp
     * @see dateFormat
     * @link https://dev.mysql.com/doc/refman/5.7/en/date-and-time-functions.html#function_from-unixtime
     */
    public static function fromUnixtime(IField $unix_timestamp, IField $format=null) {
        $args = [$unix_timestamp];
        if($format) {
            $args[] = $format;
        }
        return new UserFunc('FROM_UNIXTIME', ...$args);
    }

    /**
     * If called with no argument, returns a Unix timestamp (seconds since '1970-01-01 00:00:00' UTC). The return value is an integer if no argument is given or the argument does not include a fractional seconds part, or DECIMAL if an argument is given that includes a fractional seconds part.
     *
     * If UNIX_TIMESTAMP() is called with a date argument, it returns the value of the argument as seconds since '1970-01-01 00:00:00' UTC. The server interprets date as a value in the current time zone and converts it to an internal value in UTC. Clients can set their time zone as described in Section 11.6, “MySQL Server Time Zone Support”.
     *
     * @param IField|null $date Date to convert. May be a DATE string, a DATETIME string, a TIMESTAMP, or a number in the format YYMMDD or YYYYMMDD, optionally including a fractional seconds part.
     * @return UserFunc Number of seconds since 1970-01-01 00:00:00 UTC
     * @link https://dev.mysql.com/doc/refman/5.7/en/date-and-time-functions.html#function_unix-timestamp
     * @link https://dev.mysql.com/doc/refman/5.7/en/time-zone-support.html
     */
    public static function unixTimestamp(IField $date=null) {
        $args = [];
        if($date) {
            $args[] = $date;
        }
        return new UserFunc('UNIX_TIMESTAMP', ...$args);
    }

    /**
     * Formats the date value according to the format string.
     *
     * The following specifiers may be used in the format string. The “%” character is required before format specifier characters.
     *
     *     +-----------+--------------------------------------------------------------------------------------------------+
     *     | Specifier |                                           Description                                            |
     *     +-----------+--------------------------------------------------------------------------------------------------+
     *     | %a        | Abbreviated weekday name (Sun..Sat)                                                              |
     *     | %b        | Abbreviated month name (Jan..Dec)                                                                |
     *     | %c        | Month, numeric (0..12)                                                                           |
     *     | %D        | Day of the month with English suffix (0th, 1st, 2nd, 3rd, …)                                     |
     *     | %d        | Day of the month, numeric (00..31)                                                               |
     *     | %e        | Day of the month, numeric (0..31)                                                                |
     *     | %f        | Microseconds (000000..999999)                                                                    |
     *     | %H        | Hour (00..23)                                                                                    |
     *     | %h        | Hour (01..12)                                                                                    |
     *     | %I        | Hour (01..12)                                                                                    |
     *     | %i        | Minutes, numeric (00..59)                                                                        |
     *     | %j        | Day of year (001..366)                                                                           |
     *     | %k        | Hour (0..23)                                                                                     |
     *     | %l        | Hour (1..12)                                                                                     |
     *     | %M        | Month name (January..December)                                                                   |
     *     | %m        | Month, numeric (00..12)                                                                          |
     *     | %p        | AM or PM                                                                                         |
     *     | %r        | Time, 12-hour (hh:mm:ss followed by AM or PM)                                                    |
     *     | %S        | Seconds (00..59)                                                                                 |
     *     | %s        | Seconds (00..59)                                                                                 |
     *     | %T        | Time, 24-hour (hh:mm:ss)                                                                         |
     *     | %U        | Week (00..53), where Sunday is the first day of the week; WEEK() mode 0                          |
     *     | %u        | Week (00..53), where Monday is the first day of the week; WEEK() mode 1                          |
     *     | %V        | Week (01..53), where Sunday is the first day of the week; WEEK() mode 2; used with %X            |
     *     | %v        | Week (01..53), where Monday is the first day of the week; WEEK() mode 3; used with %x            |
     *     | %W        | Weekday name (Sunday..Saturday)                                                                  |
     *     | %w        | Day of the week (0=Sunday..6=Saturday)                                                           |
     *     | %X        | Year for the week where Sunday is the first day of the week, numeric, four digits; used with %V  |
     *     | %x        | Year for the week, where Monday is the first day of the week, numeric, four digits; used with %v |
     *     | %Y        | Year, numeric, four digits                                                                       |
     *     | %y        | Year, numeric (two digits)                                                                       |
     *     | %%        | A literal “%” character                                                                          |
     *     | %x        | x, for any “x” not listed above                                                                  |
     *     +-----------+--------------------------------------------------------------------------------------------------+
     *
     * Ranges for the month and day specifiers begin with zero due to the fact that MySQL permits the storing of incomplete dates such as '2014-00-00'.
     *
     * The language used for day and month names and abbreviations is controlled by the value of the lc_time_names system variable (Section 11.7, “MySQL Server Locale Support”).
     *
     * For the %U, %u, %V, and %v specifiers, see the description of the WEEK() function for information about the mode values. The mode affects how week numbering occurs.
     *
     * DATE_FORMAT() returns a string with a character set and collation given by character_set_connection and collation_connection so that it can return month and weekday names containing non-ASCII characters.
     *
     * @param IField $date Date to reformat
     * @param IField $format Format string
     * @link https://dev.mysql.com/doc/refman/5.7/en/date-and-time-functions.html#function_date-format
     * @link https://dev.mysql.com/doc/refman/5.7/en/locale-support.html
     * @return UserFunc
     */
    public static function dateFormat(IField $date, IField $format) {
        return new UserFunc('DATE_FORMAT', $date, $format);
    }

    // TODO: add rest of date/time functions  https://dev.mysql.com/doc/refman/5.7/en/date-and-time-functions.html
}