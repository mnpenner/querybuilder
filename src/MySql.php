<?php namespace QueryBuilder;

class MySql implements SqlConnection {

    public function id($value) {
        return '`' . str_replace('`', '``', $value) . '`';
    }

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }
}