<?php namespace QueryBuilder\MySql\Functions;

use QueryBuilder\Functions\SimpleFunc;
use QueryBuilder\IExpr;
use QueryBuilder\IIntervalUnit;
use QueryBuilder\Interval;
use QueryBuilder\StringLiteral;
use QueryBuilder\SystemVariable;

abstract class Time {


    /**
     * Add time values (intervals) to a date value.
     *
     * @param IExpr $date         Specifies the starting date or datetime value
     * @param IExpr $value        Interval value to be added or subtracted from the starting date; it may be negative.
     * @param IIntervalUnit $unit Keyword indicating the units in which the expression should be interpreted.
     * @return SimpleFunc The return value depends on the arguments:
     *
     *                    - DATETIME if the first argument is a DATETIME (or TIMESTAMP) value, or if the first argument is a DATE and the unit value uses HOURS, MINUTES, or SECONDS.
     *                    - String otherwise.
     *
     *                    To ensure that the result is DATETIME, you can use CAST() to convert the first argument to DATETIME.
     * @see https://dev.mysql.com/doc/refman/5.7/en/date-and-time-functions.html#function_date-add
     */
    public static function DateAdd(IExpr $date, IExpr $value, IIntervalUnit $unit) {
        return new SimpleFunc('DATE_ADD', $date, new Interval($value, $unit));
    }

    /**
     * Subtract a time value (interval) from a date.
     *
     * @param IExpr $date         Specifies the starting date or datetime value
     * @param IExpr $value        Interval value to be added or subtracted from the starting date; it may be negative.
     * @param IIntervalUnit $unit Keyword indicating the units in which the expression should be interpreted.
     * @return SimpleFunc The return value depends on the arguments:
     *
     *                    - DATETIME if the first argument is a DATETIME (or TIMESTAMP) value, or if the first argument is a DATE and the unit value uses HOURS, MINUTES, or SECONDS.
     *                    - String otherwise.
     *
     *                    To ensure that the result is DATETIME, you can use CAST() to convert the first argument to DATETIME.
     * @see https://dev.mysql.com/doc/refman/5.7/en/date-and-time-functions.html#function_date-add
     */
    public static function DateSub(IExpr $date, IExpr $value, IIntervalUnit $unit) {
        return new SimpleFunc('DATE_SUB', $date, new Interval($value, $unit));
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
     * @param IExpr $dt
     * @param IExpr $from_tz
     * @param IExpr $to_tz
     * @return SimpleFunc
     * @see https://dev.mysql.com/doc/refman/5.7/en/date-and-time-functions.html#function_convert-tz
     * @see https://dev.mysql.com/doc/refman/5.7/en/time-zone-support.html
     */
    public static function convertTZ(IExpr $dt, IExpr $from_tz, IExpr $to_tz) {
        return new SimpleFunc('CONVERT_TZ', $dt, $from_tz, $to_tz);
    }

    /**
     * Converts a unix timestamp to a MySQL datetime in the specified or current time zone.
     *
     * @param IExpr $unixtime Number of seconds since 1970-01-01 00:00:00 UTC
     * @param IExpr|null $timezone Defaults to @@session.time_zone
     * @return SimpleFunc
     */
    public static function unixToDateTime(IExpr $unixtime, IExpr $timezone=null) {
        if($timezone === null) $timezone = new SystemVariable('session.time_zone');
        return self::convertTZ(self::DateAdd(new StringLiteral('1970-01-01'), $unixtime, Interval::SECOND()), new StringLiteral('UTC'), $timezone);
    }
}