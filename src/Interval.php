<?php namespace QueryBuilder;

class Interval implements IInterval {
    /** @var IExpr */
    private $_value;
    /** @var IIntervalUnit */
    private $_unit;

    public function __construct(IExpr $value, IIntervalUnit $unit) {
        $this->_value = $value;
        $this->_unit = $unit;
    }

    public static function DAY() {
        return new RawIntervalUnit('DAY');
    }

    public static function DAY_HOUR() {
        return new RawIntervalUnit('DAY_HOUR');
    }

    public static function DAY_MICROSECOND() {
        return new RawIntervalUnit('DAY_MICROSECOND');
    }

    public static function DAY_MINUTE() {
        return new RawIntervalUnit('DAY_MINUTE');
    }

    public static function DAY_SECOND() {
        return new RawIntervalUnit('DAY_SECOND');
    }

    public static function HOUR() {
        return new RawIntervalUnit('HOUR');
    }

    public static function HOUR_MICROSECOND() {
        return new RawIntervalUnit('HOUR_MICROSECOND');
    }

    public static function HOUR_MINUTE() {
        return new RawIntervalUnit('HOUR_MINUTE');
    }

    public static function HOUR_SECOND() {
        return new RawIntervalUnit('HOUR_SECOND');
    }

    public static function MICROSECOND() {
        return new RawIntervalUnit('MICROSECOND');
    }

    public static function MINUTE() {
        return new RawIntervalUnit('MINUTE');
    }

    public static function MINUTE_MICROSECOND() {
        return new RawIntervalUnit('MINUTE_MICROSECOND');
    }

    public static function MINUTE_SECOND() {
        return new RawIntervalUnit('MINUTE_SECOND');
    }

    public static function MONTH() {
        return new RawIntervalUnit('MONTH');
    }

    public static function QUARTER() {
        return new RawIntervalUnit('QUARTER');
    }

    public static function SECOND() {
        return new RawIntervalUnit('SECOND');
    }

    public static function SECOND_MICROSECOND() {
        return new RawIntervalUnit('SECOND_MICROSECOND');
    }

    public static function WEEK() {
        return new RawIntervalUnit('WEEK');
    }

    public static function YEAR() {
        return new RawIntervalUnit('YEAR');
    }

    public static function YEAR_MONTH() {
        return new RawIntervalUnit('YEAR_MONTH');
    }

    public function toSql(ISqlConnection $conn) {
        return 'INTERVAL '.$this->_value->toSql($conn).' '.$this->_unit->toSql($conn);
    }
}