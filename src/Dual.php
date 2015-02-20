<?php
namespace QueryBuilder;

final class Dual implements ITableRef {
    public function toSql(SqlConnection $sql) {
        return 'DUAL';
    }

    private function __construct() {}

    public static function value() {
        static $value;
        if(!$value) $value = new self;
        return $value;
    }
}
