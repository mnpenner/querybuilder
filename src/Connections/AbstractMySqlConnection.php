<?php namespace QueryBuilder\Connections;

use QueryBuilder\Util;

abstract class AbstractMySqlConnection extends AbstractSqlConnection {

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

    abstract public function getCharset();

    public function id($name, array &$ctx) {
        return '`' . Util::mbStrReplace('`', '``', $name, $this->getCharset()) . '`';
    }
}