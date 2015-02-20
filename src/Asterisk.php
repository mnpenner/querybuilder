<?php
namespace QueryBuilder;

class Asterisk implements ISql, IExpr {
    public function toSql(SqlConnection $sql) {
        return '*';
    }

    private function __construct() {}

    public static function value() {
        static $value;
        if($value === null) $value = new self;
        return $value;
    }
}
