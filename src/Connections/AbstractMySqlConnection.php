<?php namespace QueryBuilder\Connections;

use QueryBuilder\Interfaces\IDict;
use QueryBuilder\Util;

abstract class AbstractMySqlConnection extends AbstractSqlConnection {

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

    abstract public function getCharset();

    public function id($name, IDict $ctx) {
        return '`' . Util::mbStrReplace('`', '``', $name, $this->getCharset()) . '`';
    }
}