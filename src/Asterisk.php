<?php
namespace QueryBuilder;

final class Asterisk implements IExpr {
    public function toSql(ISqlConnection $sql) {
        return '*';
    }

    private function __construct() {}

    public static function value() {
        static $value;
        if(!$value) $value = new self;
        return $value;
    }
}
