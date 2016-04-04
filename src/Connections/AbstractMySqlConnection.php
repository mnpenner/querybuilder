<?php namespace QueryBuilder\Connections;

abstract class AbstractMySqlConnection extends AbstractSqlConnection {

    public function id($name) {
        // FIXME: there's a potential vulnerability in here... if $name is a multi-byte char string containin 0x60 then we might try escaping ` when we shouldn't
        return '`' . str_replace('`', '``', $name) . '`';
    }

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

}