<?php
namespace QueryBuilder;

class Wild implements ISql, ISelectExpr {
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
