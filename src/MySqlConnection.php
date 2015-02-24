<?php namespace QueryBuilder;

abstract class MySqlConnection extends ASqlConnection {

    public function id($value) {
        return '`' . str_replace('`', '``', $value) . '`';
    }

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

}