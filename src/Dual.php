<?php
namespace QueryBuilder;

final class Dual implements ITable { // todo: remove this class. maybe make a helper return a RawTable for this
    public function toSql(ISqlConnection $sql) {
        return 'DUAL';
    }

    private function __construct() {}

    public static function value() {
        static $value;
        if(!$value) $value = new self;
        return $value;
    }
}
