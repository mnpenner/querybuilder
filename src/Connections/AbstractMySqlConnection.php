<?php namespace QueryBuilder\Connections;

abstract class AbstractMySqlConnection extends AbstractSqlConnection {

    public function id($name) {
        return '`' . str_replace('`', '``', $name) . '`';
    }

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

}