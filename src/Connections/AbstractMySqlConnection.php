<?php namespace QueryBuilder\Connections;

abstract class AbstractMySqlConnection extends AbstractSqlConnection {

    public function id($value) {
        return '`' . str_replace('`', '``', $value) . '`';
    }

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

}